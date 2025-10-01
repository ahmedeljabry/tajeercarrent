<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ImageSizeResolver
{
    public static function get(string $src, bool $allowExternalFetch = false): array
    {
        if (!$src) return [null, null];

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
