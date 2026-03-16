<?php

namespace App\Services;

use App\Models\LinkPreview;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class LinkPreviewService
{
    protected array $memoryCache = [];

    public function refresh(?string $url, bool $force = false): ?LinkPreview
    {
        $url = $this->sanitizeUrl($url);

        if (! $url || ! $this->tableExists()) {
            return null;
        }

        if (! $force && isset($this->memoryCache[$url])) {
            return $this->memoryCache[$url];
        }

        $urlHash = $this->hashUrl($url);
        $preview = LinkPreview::where('url_hash', $urlHash)->first();

        if ($preview && ! $force && $preview->last_fetched_at && $preview->last_fetched_at->gt(now()->subDays(7))) {
            return $this->memoryCache[$url] = $preview;
        }

        $metadata = $this->fetchMetadata($url);

        $preview = LinkPreview::updateOrCreate(
            ['url_hash' => $urlHash],
            [
                'url' => $url,
                'title' => $metadata['title'],
                'description' => $metadata['description'],
                'favicon' => $metadata['favicon'],
                'image' => $metadata['image'],
                'last_fetched_at' => now(),
            ],
        );

        return $this->memoryCache[$url] = $preview;
    }

    public function cached(?string $url): ?LinkPreview
    {
        $url = $this->sanitizeUrl($url);

        if (! $url || ! $this->tableExists()) {
            return null;
        }

        if (isset($this->memoryCache[$url])) {
            return $this->memoryCache[$url];
        }

        return $this->memoryCache[$url] = LinkPreview::where('url_hash', $this->hashUrl($url))->first();
    }

    public function tableExists(): bool
    {
        static $exists;

        if ($exists === null) {
            $exists = Schema::hasTable('link_previews');
        }

        return $exists;
    }

    protected function fetchMetadata(string $url): array
    {
        $fallback = $this->fallbackMetadata($url);

        try {
            $response = Http::timeout(8)
                ->connectTimeout(4)
                ->withHeaders([
                    'User-Agent' => 'byoo.pro Preview Bot/2.0 (+https://byoo.pro)',
                    'Accept' => 'text/html,application/xhtml+xml',
                ])
                ->get($url);

            if (! $response->successful()) {
                return $fallback;
            }

            $html = (string) $response->body();

            if ($html === '') {
                return $fallback;
            }

            return array_merge($fallback, $this->parseHtml($html, $url));
        } catch (Throwable) {
            return $fallback;
        }
    }

    protected function parseHtml(string $html, string $url): array
    {
        $dom = new DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $loaded = $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        if (! $loaded) {
            return [];
        }

        $xpath = new DOMXPath($dom);

        $title = $this->firstNonEmpty([
            $this->metaContent($xpath, 'property', 'og:title'),
            $this->metaContent($xpath, 'name', 'twitter:title'),
            $this->nodeText($xpath, '//title'),
        ]);

        $description = $this->firstNonEmpty([
            $this->metaContent($xpath, 'property', 'og:description'),
            $this->metaContent($xpath, 'name', 'description'),
            $this->metaContent($xpath, 'name', 'twitter:description'),
        ]);

        $image = $this->firstNonEmpty([
            $this->metaContent($xpath, 'property', 'og:image'),
            $this->metaContent($xpath, 'name', 'twitter:image'),
        ]);

        $favicon = $this->firstNonEmpty([
            $this->linkHref($xpath, 'icon'),
            $this->linkHref($xpath, 'shortcut icon'),
            $this->linkHref($xpath, 'apple-touch-icon'),
        ]);

        return array_filter([
            'title' => $title ? Str::limit(trim($title), 255, '') : null,
            'description' => $description ? Str::limit(trim($description), 500, '') : null,
            'image' => $this->absolutizeUrl($image, $url),
            'favicon' => $this->absolutizeUrl($favicon, $url),
        ], static fn ($value) => filled($value));
    }

    protected function metaContent(DOMXPath $xpath, string $attribute, string $value): ?string
    {
        $value = strtolower($value);
        $nodes = $xpath->query("//meta[translate(@{$attribute}, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz')='{$value}']");

        if (! $nodes || $nodes->length === 0) {
            return null;
        }

        return $nodes->item(0)?->getAttribute('content') ?: null;
    }

    protected function linkHref(DOMXPath $xpath, string $relValue): ?string
    {
        $relValue = strtolower($relValue);
        $nodes = $xpath->query('//link[@rel and @href]');

        if (! $nodes) {
            return null;
        }

        foreach ($nodes as $node) {
            $rel = strtolower(trim((string) $node->attributes?->getNamedItem('rel')?->nodeValue));

            if ($rel === $relValue) {
                return $node->attributes?->getNamedItem('href')?->nodeValue ?: null;
            }
        }

        return null;
    }

    protected function nodeText(DOMXPath $xpath, string $query): ?string
    {
        $nodes = $xpath->query($query);

        if (! $nodes || $nodes->length === 0) {
            return null;
        }

        return trim((string) $nodes->item(0)?->textContent);
    }

    protected function fallbackMetadata(string $url): array
    {
        $parts = parse_url($url);
        $host = $parts['host'] ?? $url;
        $scheme = $parts['scheme'] ?? 'https';

        return [
            'title' => $host,
            'description' => null,
            'favicon' => $host ? "{$scheme}://{$host}/favicon.ico" : null,
            'image' => null,
        ];
    }

    protected function absolutizeUrl(?string $candidate, string $baseUrl): ?string
    {
        $candidate = trim((string) $candidate);

        if ($candidate === '') {
            return null;
        }

        if (Str::startsWith($candidate, ['http://', 'https://'])) {
            return $candidate;
        }

        $base = parse_url($baseUrl);

        if (! $base || empty($base['host'])) {
            return $candidate;
        }

        $scheme = $base['scheme'] ?? 'https';
        $host = $base['host'];
        $port = isset($base['port']) ? ':'.$base['port'] : '';
        $root = "{$scheme}://{$host}{$port}";

        if (Str::startsWith($candidate, '//')) {
            return $scheme.':'.$candidate;
        }

        if (Str::startsWith($candidate, '/')) {
            return $root.$candidate;
        }

        $path = $base['path'] ?? '/';
        $directory = rtrim(str_replace('\\', '/', dirname($path)), '/.');

        return $root.($directory ? '/'.$directory : '').'/'.$candidate;
    }

    protected function firstNonEmpty(array $values): ?string
    {
        foreach ($values as $value) {
            if (filled($value)) {
                return (string) $value;
            }
        }

        return null;
    }

    protected function sanitizeUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        return $url !== '' ? $url : null;
    }

    protected function hashUrl(string $url): string
    {
        return hash('sha256', $url);
    }
}
