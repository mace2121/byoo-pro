<?php

namespace App\Services;

use App\Models\Block;
use App\Models\Link;
use App\Models\LinkPreview;
use App\Models\User;
use App\Support\WhatsAppLink;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BlockService
{
    protected array $previewCache = [];

    public function __construct(protected LinkPreviewService $linkPreviewService)
    {
    }

    public function getRenderableBlocks(User $user): Collection
    {
        if ($this->blocksTableExists()) {
            $blocks = $user->blocks()
                ->with('sourceLink.preview')
                ->where('is_active', true)
                ->orderBy('position')
                ->get();

            if ($blocks->isNotEmpty()) {
                return $blocks->map(fn (Block $block) => $this->normalizeBlock($block));
            }
        }

        return $this->mapLinksToBlocks($user);
    }

    public function getDashboardBlocks(User $user): Collection
    {
        if (! $this->blocksTableExists()) {
            return collect();
        }

        $this->syncLegacyLinks($user);

        return $user->blocks()
            ->with('sourceLink.preview')
            ->orderBy('position')
            ->get();
    }

    public function syncLegacyLinks(User $user): void
    {
        if (! $this->blocksTableExists()) {
            return;
        }

        $links = $user->links()->orderBy('order')->get();

        if ($links->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($user, $links) {
            foreach ($links as $link) {
                $block = Block::firstOrNew([
                    'user_id' => $user->id,
                    'source_link_id' => $link->id,
                ]);

                $isNew = ! $block->exists;

                $block->type = 'link';
                $block->title = $link->title;
                $block->description = null;
                $block->image = null;
                $block->url = $link->url;
                $block->button_type = 'external_link';
                $block->button_link = $link->url;
                $block->position = $isNew ? $link->order : $block->position;
                $block->is_active = (bool) $link->is_active;
                $block->data = array_replace($block->data ?? [], [
                    'icon' => $link->icon,
                ]);
                $block->save();
            }
        });
    }

    public function blocksTableExists(): bool
    {
        static $exists;

        if ($exists === null) {
            $exists = Schema::hasTable('blocks');
        }

        return $exists;
    }

    protected function mapLinksToBlocks(User $user): Collection
    {
        $now = now();

        return $user->links()
            ->where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', $now);
            })
            ->orderBy('order')
            ->get()
            ->map(fn (Link $link) => (object) [
                'id' => 'legacy-link-'.$link->id,
                'db_id' => null,
                'source_link_id' => $link->id,
                'type' => 'link',
                'title' => $link->title,
                'description' => null,
                'image' => null,
                'price' => null,
                'icon' => $link->icon_class,
                'href' => route('public.redirect', $link),
                'button_label' => null,
                'button_type' => 'external_link',
                'password_protected' => filled($link->password),
                'position' => $link->order,
                'is_active' => (bool) $link->is_active,
                'preview' => $this->mapPreview($this->resolvePreview($link->url)),
            ]);
    }

    protected function normalizeBlock(Block $block): object
    {
        $data = is_array($block->data) ? $block->data : [];
        $type = $block->type ?: 'link';
        $sourceLink = $block->sourceLink;
        $icon = $data['icon'] ?? ($sourceLink?->icon_class ?? 'fas fa-link');
        $preview = $this->resolvePreview($block->url ?: $sourceLink?->url, $sourceLink?->preview);

        return (object) [
            'id' => 'block-'.$block->id,
            'db_id' => $block->id,
            'source_link_id' => $block->source_link_id,
            'type' => $type,
            'title' => $block->title,
            'description' => $block->description,
            'image' => $block->image_url,
            'price' => $data['price'] ?? null,
            'icon' => $icon,
            'href' => $this->resolveBlockUrl($block, $data),
            'button_label' => $this->resolveButtonLabel($block),
            'button_type' => $block->button_type ?: 'external_link',
            'password_protected' => filled($sourceLink?->password),
            'position' => $block->position,
            'is_active' => (bool) $block->is_active,
            'preview' => $this->mapPreview($preview),
        ];
    }

    protected function resolveBlockUrl(Block $block, array $data): string
    {
        if ($block->type === 'product') {
            if ($block->button_type === 'whatsapp') {
                $message = $data['whatsapp_message'] ?? ('Merhaba, '.$block->title.' urunu hakkinda bilgi almak istiyorum.');

                return WhatsAppLink::generate($block->button_link ?: $block->url, $message);
            }

            return $block->button_link ?: $block->url ?: '#';
        }

        if ($block->sourceLink) {
            return route('public.redirect', $block->sourceLink);
        }

        return $block->url ?: $block->button_link ?: '#';
    }

    protected function resolveButtonLabel(Block $block): ?string
    {
        if ($block->type !== 'product') {
            return null;
        }

        return $block->button_type === 'whatsapp'
            ? 'WhatsApp ile iletisim'
            : 'Urunu incele';
    }

    protected function resolvePreview(?string $url, ?LinkPreview $loadedPreview = null): ?LinkPreview
    {
        $url = trim((string) $url);

        if ($url === '' || ! $this->linkPreviewService->tableExists()) {
            return null;
        }

        if ($loadedPreview) {
            return $this->previewCache[$url] = $loadedPreview;
        }

        if (array_key_exists($url, $this->previewCache)) {
            return $this->previewCache[$url];
        }

        return $this->previewCache[$url] = $this->linkPreviewService->cached($url);
    }

    protected function mapPreview(?LinkPreview $preview): ?object
    {
        if (! $preview) {
            return null;
        }

        $host = parse_url($preview->url, PHP_URL_HOST) ?: null;

        return (object) [
            'title' => $preview->title,
            'description' => $preview->description,
            'favicon' => $preview->favicon,
            'image' => $preview->image,
            'domain' => $host,
        ];
    }

}
