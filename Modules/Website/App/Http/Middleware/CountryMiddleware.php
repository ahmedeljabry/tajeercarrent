<?php

namespace Modules\Website\App\Http\Middleware;

use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class CountryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('website.switch.*'))
            return $next($request);

        $route = $request->route();
        $routeName = $route?->getName();

        $segments = $request->segments();
        $localeKeys = \LaravelLocalization::getSupportedLanguagesKeys();
        $offset = in_array($segments[0] ?? '', $localeKeys, true) ? 1 : 0;

        $country = Country::whereSlug($segments[$offset] ?? null)->first();
        $city = City::whereSlug($segments[$offset + 1] ?? null)->first();
        $hadCountryInUrl = isset($segments[$offset]) && ($segments[$offset] !== null && $segments[$offset] !== '');
        $hadCityInUrl = isset($segments[$offset + 1]) && ($segments[$offset + 1] !== null && $segments[$offset + 1] !== '');

        if (!$country) {
            $defaultCountrySlug = config('website.default_country_slug');
            $defaultCitySlug = config('website.default_city_slug');

            $country = ($defaultCountrySlug ? Country::whereSlug($defaultCountrySlug)->first() : null)
                ?? Country::whereDefault(true)->first()
                ?? Country::first();

            if ($country) {
                $city = $defaultCitySlug
                    ? $country->cities()->whereSlug($defaultCitySlug)->first()
                    : null;
                $city = $city
                    ?? $country->cities()->whereDefault(true)->first()
                    ?? $country->cities()->first();
            }
            if ($country && $city) {
                Cookie::queue('country_id', $country->id, 60 * 60 * 24 * 30);
                Cookie::queue('city_id', $city->id, 60 * 60 * 24 * 30);
                // Redirect to include defaults on all routes except home
                if ($routeName && $routeName !== 'home') {
                    $params = $route->parameters();
                    $params['country'] = $country;
                    $params['city'] = $city;
                    return redirect()->route($routeName, $params);
                }
            }
        }

        if ($country && !$city) {
            $defaultCitySlug = config('website.default_city_slug');
            $city = $defaultCitySlug
                ? $country->cities()->whereSlug($defaultCitySlug)->first()
                : null;
            $city = $city ?? $country->cities()->whereDefault(true)->first() ?? $country->cities()->first();
            if ($city) {
                Cookie::queue('country_id', $country->id, 60 * 60 * 24 * 30);
                Cookie::queue('city_id', $city->id, 60 * 60 * 24 * 30);
                if ($routeName && $routeName !== 'home') {
                    $params = $route->parameters();
                    $params['country'] = $country;
                    $params['city'] = $city;
                    return redirect()->route($routeName, $params);
                }
            }
        }

        if ($country && $city) {
            $isHome = ($routeName === 'home');
            if (!$isHome || ($hadCountryInUrl && $hadCityInUrl)) {
                URL::defaults([
                    'locale' => \LaravelLocalization::getCurrentLocale(),
                    'country' => $country->slug,
                    'city' => $city->slug,
                ]);
            } else {
                URL::defaults([
                    'locale' => \LaravelLocalization::getCurrentLocale(),
                ]);
            }
            app('country')->setCountry($country->id);
            app('country')->setCity($city->id);
        }
        return $next($request);
    }
}
