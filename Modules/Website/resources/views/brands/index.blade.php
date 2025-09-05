@extends('website::layouts.master')
@section('css')
    <link href="{{asset('/css/types.css')}}" type="text/css" rel="stylesheet" />
@endsection

@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => \App\Models\SEO::where('type','car-brands')->first(),
        "title" => app('settings')->get('page_car_brands_title'),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection

@section("content")
    <main id="car-brands">
        <section class="new-pages-banner">
            <picture>
                <img src="{{asset('/assets/images/car-subscription-new-image.png')}}" alt="{{app('settings')->get('page_car_brands_title') ?? __('lang.Car Brands')}}">
            </picture>
            <h2>{{app('settings')->get('page_car_brands_title') ?? __('lang.Car Brands')}}</h2>
        </section>

        @include('website::cars.parts.breadcrumb', [
              'breadcrumbs' => [
                  app('settings')->get('page_car_brands_title') ?? __('lang.Car Brands') =>  LaravelLocalization::getLocalizedUrl(null, route('brands.index'))
              ]
        ])

        <section class="car-type-section">
            @if (($content = \App\Models\Content::where('type', 'car-brands')->first()))
                <div class="container">
                    <div class="section-header">
                        @if ($content->title)
                            <div class="section-header-title">
                                <h3>{{$content->title}}</h3>
                                <div class="black-line"></div>
                            </div>
                        @endif
                        <div class="description-container">
                            @if ($content->description)
                                <p class="description-text">
                                    {!! $content->description !!}
                                </p>
                                <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="choose-fav-car-slider-wrapper container">
                <div class="container row ">
                    @foreach(app('cars')->brands as $brand)
                        <div class="col-6 col-md-4 col-lg-3 mb-3 car-type-card">
                            <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.cars.brands.show', ['brand' => $brand]))}}" class="car-type-brand-slide">
                                <picture>
                                    <img src="/storage/{{\App\Helpers\WebpImage::generateUrl($brand->image)}}" alt="{{$brand->title}}">
                                </picture>
                                <div class="car-type-brand-slide-footer">
                                    <p>{{$brand->title}}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if (($content = \App\Models\Content::where('type', 'car-brands')->first()) && $content->image_2 && $content->title_2 && $content->description_2)
            <section class="home-content-section">
                <div class="container">
                    <picture>
                        <img src="/storage/{{\App\Helpers\WebpImage::generateUrl($content->image_2)}}" alt="{{$content->title_2}}">
                    </picture>
                    <div class="home-content-container">
                        <div class="home-desc">
                            <h2>{{$content->title_2}}</h2>
                            {!! $content->description_2 !!}
                        </div>
                        <div class="main-btn">{{__('lang.Read More')}}</div>
                    </div>
                </div>
            </section>
        @endif

        @if (($content = \App\Models\Content::where('type', 'car-brands')->first()) && $content->image_3 && $content->title_3 && $content->description_3)
            <section class="home-content-section">
                <div class="container">
                    <picture>
                        <img src="/storage/{{\App\Helpers\WebpImage::generateUrl($content->image_3)}}" alt="{{$content->title_3}}">
                    </picture>
                    <div class="home-content-container">
                        <div class="home-desc">
                            <h2>{{$content->title_3}}</h2>
                            {!! $content->description_3 !!}
                        </div>
                        <div class="main-btn">{{__('lang.Read More')}}</div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection