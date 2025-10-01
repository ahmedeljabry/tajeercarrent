<?php

namespace App\Support;

final class AltTextHelper
{
    public static function smartTrim(string $text, int $max = 120): string
    {
        $t = trim(preg_replace('/\s+/', ' ', strip_tags($text)));

        if (mb_strlen($t) <= $max) return $t;

        $cut = mb_substr($t, 0, $max + 1);
        $boundary = max(
            mb_strrpos($cut, '،') ?: 0,
            mb_strrpos($cut, ',') ?: 0,
            mb_strrpos($cut, '.') ?: 0,
            mb_strrpos($cut, '؛') ?: 0,
            mb_strrpos($cut, '—') ?: 0,
            mb_strrpos($cut, '-') ?: 0,
            mb_strrpos($cut, ' ') ?: 0
        );

        if ($boundary > 40) { 
            $t = mb_substr($t, 0, $boundary);
        } else {
            $t = rtrim(mb_substr($t, 0, $max));
        }
        return rtrim($t, " .،,؛-—") . '…';
    }

    public static function nearestLinkText(\DOMElement $img): ?string
    {
        $node = $img->parentNode;
        while ($node && $node instanceof \DOMElement) {
            if (strtolower($node->tagName) === 'a') {
                $label = trim($node->getAttribute('aria-label') ?: '');
                if ($label !== '') return $label;
                $txt = trim($node->textContent ?? '');
                if ($txt !== '') return $txt;
                break;
            }
            $node = $node->parentNode;
        }
        return null;
    }

    public static function isDecorative(\DOMElement $img): bool
    {
        if (strtolower($img->getAttribute('aria-hidden') ?? '') === 'true') return true;
        if (strtolower($img->getAttribute('role') ?? '') === 'presentation') return true;
        if (preg_match('/\b(icon|decorative|bg|spacer)\b/i', $img->getAttribute('class') ?? '')) return true;
        return false;
    }

    public static function isLogo(\DOMElement $img): bool
    {
        $blob = strtolower(($img->getAttribute('src') ?? '') . ' ' . ($img->getAttribute('alt') ?? '') . ' ' . ($img->getAttribute('class') ?? ''));
        return str_contains($blob, 'logo');
    }
}
