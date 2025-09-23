<?php

namespace Modules\Website\App\Http\Middleware;

use Closure;
use http\Url;
use Illuminate\Http\Request;
use App\Models\Country as Countries;

class Country
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        app('country')->setCountry(\Cookie::get('country_id'));
        app('country')->setCity(\Cookie::get('city_id'));

        $country = app('country')->getCountry();
        $city = app('country')->getCity();
        if ($country && $city) {
            \Illuminate\Support\Facades\URL::defaults([
                'country' => $country->slug,
                'city' => $city->slug,
            ]);
        }
        return $next($request);
    }
}
