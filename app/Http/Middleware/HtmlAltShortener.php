<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\AltTextHelper;
class HtmlAltShortener
{
    protected array $excludePaths = ['admin/*','api/*'];
    protected int   $maxImagesPerResponse = 250;
    protected int   $maxAltLength = 120;    
    protected bool  $onlyWhenTooLong = true;
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

        $response = $next($request);

        $ctype  = $response->headers->get('Content-Type', '');
        $status = $response->getStatusCode();
        if ($status !== 200 || stripos($ctype, 'text/html') === false) return $response;

        $html = $response->getContent();
        if (!$html || stripos($html, '<img') === false) return $response;

        $internal = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);

        $imgs = $dom->getElementsByTagName('img');
        $n = 0;

        foreach ($imgs as $img) {
            if (++$n > $this->maxImagesPerResponse) break;

            /** @var \DOMElement $img */
            if (AltTextHelper::isDecorative($img)) {
                $img->setAttribute('alt', '');
                continue;
            }

            if (AltTextHelper::isLogo($img)) {
                $img->setAttribute('alt', config('app.name', 'Tajeer Car Rent'));
                continue;
            }

            $alt = $img->getAttribute('alt') ?? '';

            if (trim($alt) === '') {
                if ($linkText = AltTextHelper::nearestLinkText($img)) {
                    $img->setAttribute('alt', AltTextHelper::smartTrim($linkText, $this->maxAltLength));
                }
                continue;
            }

            if (!$this->onlyWhenTooLong || mb_strlen($alt) > $this->maxAltLength) {
                $short = AltTextHelper::smartTrim($alt, $this->maxAltLength);

                if ($linkText = AltTextHelper::nearestLinkText($img)) {
                    $short = AltTextHelper::smartTrim($linkText, $this->maxAltLength);
                }

                if ($short !== $alt) {
                    $img->setAttribute('data-alt-full', mb_substr($alt, 0, 5000)); 
                    $img->setAttribute('alt', $short);
                }
            }
        }

        $response->setContent($dom->saveHTML());
        libxml_clear_errors();
        libxml_use_internal_errors($internal);

        return $response;
    }
}