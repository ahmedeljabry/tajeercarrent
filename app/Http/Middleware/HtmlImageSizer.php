<?php

namespace App\Http\Middleware;

use App\Support\ImageSizeResolver;
use Closure;
use Illuminate\Http\Request;

class HtmlImageSizer
{
    protected array $excludePaths = [
        'admin/*', 'api/*',
    ];

    protected int $maxImagesPerResponse = 150;
    protected bool $allowExternalFetch = false;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($this->excludePaths as $pat) {
            if ($request->is($pat)) return $next($request);
        }

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);
        $ctype = $response->headers->get('Content-Type', '');
        $status = $response->getStatusCode();

        if ($status !== 200 || stripos($ctype, 'text/html') === false) {
            return $response;
        }

        $html = $response->getContent();
        if (!$html || stripos($html, '<img') === false) {
            return $response;
        }

        $internalErrors = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();

        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

        $imgs = $dom->getElementsByTagName('img');
        $processed = 0;

        foreach ($imgs as $img) {
            if ($processed >= $this->maxImagesPerResponse) break;
            $processed++;

            /** @var \DOMElement $img */
            $src = trim((string)$img->getAttribute('src'));
            if ($src === '') continue;

            $hasW = $img->hasAttribute('width') && (int)$img->getAttribute('width') > 0;
            $hasH = $img->hasAttribute('height') && (int)$img->getAttribute('height') > 0;

            if (!$img->hasAttribute('decoding')) {
                $img->setAttribute('decoding', 'async');
            }
            if (!$img->hasAttribute('loading')) {
                $img->setAttribute('loading', 'lazy');
            }
            if (!$img->hasAttribute('fetchpriority')) {
                $img->setAttribute('fetchpriority', 'auto');
            }

            if ($hasW && $hasH) {
                continue; 
            }

            [$w, $h] = ImageSizeResolver::get($src, $this->allowExternalFetch);

            if ($w && $h) {
                if (!$hasW) $img->setAttribute('width', (string)$w);
                if (!$hasH) $img->setAttribute('height', (string)$h);
                continue;
            }

  
            if (!$img->hasAttribute('style')) {
                $img->setAttribute('style', 'aspect-ratio: 4 / 3;');
            }
        }

        $output = $dom->saveHTML();
        $response->setContent($output);

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $response;
    }
}
