<?php

namespace App\Support;

class WhatsAppLink
{
    public static function generate(?string $phoneOrUrl, ?string $message = null): string
    {
        $phoneOrUrl = trim((string) $phoneOrUrl);

        if ($phoneOrUrl === '') {
            return '#';
        }

        $encodedMessage = filled($message) ? rawurlencode((string) $message) : null;

        if (str_starts_with($phoneOrUrl, 'http://') || str_starts_with($phoneOrUrl, 'https://')) {
            if (! $encodedMessage) {
                return $phoneOrUrl;
            }

            $separator = str_contains($phoneOrUrl, '?') ? '&' : '?';

            return $phoneOrUrl.$separator.'text='.$encodedMessage;
        }

        $phone = preg_replace('/\D+/', '', $phoneOrUrl) ?? '';

        if ($phone === '') {
            return '#';
        }

        $url = 'https://wa.me/'.$phone;

        return $encodedMessage ? $url.'?text='.$encodedMessage : $url;
    }
}
