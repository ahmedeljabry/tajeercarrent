<?php

return [
    'name' => 'Website',
    // Defaults used when country/city are not present in URL (first visit)
    'default_country_slug' => env('WEBSITE_DEFAULT_COUNTRY', 'uae'),
    'default_city_slug' => env('WEBSITE_DEFAULT_CITY', 'dubai'),
];
