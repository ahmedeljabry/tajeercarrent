<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ImageSizeResolver
{
    /**
     * Detect if the URL already encodes explicit width and height so we should not add them.
     * Examples handled:
     *  - Query params like ?w=800&h=600 or ?width=800&height=600
     *  - Filename pattern like image-800x600.jpg
     */
    public static function hasDimensionsInUrl(string $src): bool
    {
        if (!$src) return false;

        $path = (string) (parse_url($src, PHP_URL_PATH) ?? '');
        $query = (string) (parse_url($src, PHP_URL_QUERY) ?? '');

        // Pattern like -800x600 before file extension
        if ($path && preg_match('/-(\d{1,5})x(\d{1,5})(?=\.[a-zA-Z]{2,5}\b)/', $path)) {
            return true;
        }

        if ($query) {
            parse_str($query, $params);
            $w = $params['w'] ?? $params['width'] ?? null;
            $h = $params['h'] ?? $params['height'] ?? null;
            if (is_numeric($w) && is_numeric($h) && (int)$w > 0 && (int)$h > 0) {
                return true;
            }
        }

        return false;
    }

    public static function get(string $src, bool $allowExternalFetch = false): array
    {
        if (!$src) return [null, null];

        // If URL already carries explicit dimensions, opt-out from adding attributes
        if (self::hasDimensionsInUrl($src)) {
            return [null, null];
        }

        $cacheKey = 'imgsize:' . md5($src);

        return Cache::remember($cacheKey, now()->addDays(14), function () use ($src, $allowExternalFetch) {
            $path = public_path(parse_url($src, PHP_URL_PATH) ?? '');
            if (is_file($path)) {
                $size = @getimagesize($path);
                if (is_array($size)) {
                    return [(int)($size[0] ?? 0) ?: null, (int)($size[1] ?? 0) ?: null];
                }
            }

            if (Str::startsWith($src, ['/storage/', 'storage/'])) {
                $storagePath = public_path(parse_url($src, PHP_URL_PATH));
                if (is_file($storagePath)) {
                    $size = @getimagesize($storagePath);
                    if (is_array($size)) {
                        return [(int)($size[0] ?? 0) ?: null, (int)($size[1] ?? 0) ?: null];
                    }
                }
            }

            if ($allowExternalFetch && Str::startsWith($src, ['http://', 'https://'])) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
                    $data = @file_get_contents($src, false, $ctx);
                    if ($data) {
                        $size = @getimagesizefromstring($data);
                        if (is_array($size)) {
                            return [(int)($size[0] ?? 0) ?: null, (int)($size[1] ?? 0) ?: null];
                        }
                    }
                } catch (\Throwable $e) {
                    
                }
            }

            return [null, null];
        });
    }
}
