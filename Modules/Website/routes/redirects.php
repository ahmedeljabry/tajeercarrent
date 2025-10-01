<?php

use Illuminate\Support\Facades\Route;

$redirects = [
    '/en/uae/dubai/types/with-driver' => '/en/uae/dubai/cars/with-drivers',
    '/ar/uae/dubai/types/with-driver' => '/ar/uae/dubai/cars/with-drivers',
    '/ru/uae/dubai/types/with-driver' => '/ru/uae/dubai/cars/with-drivers',

    '/en/' => '/en',
    '/ar/' => '/ar',
    '/ru/' => '/ru',

    '/en/en' => '/en',
    '/ar/en' => '/ar',
    '/ru/en' => '/ru',
];

foreach ($redirects as $from => $to) {
    Route::get($from, fn() => redirect()->to($to, 301));
}
