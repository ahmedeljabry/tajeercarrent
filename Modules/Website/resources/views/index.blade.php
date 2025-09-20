
@extends('website::layouts.master')

@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => \App\Models\SEO::where('type','home')->first(),
        "title" => app('settings')->get('title'),
        "image" => secure_url('/') . '/website/images/fav.jpg'
    ])
@endsection

@section("content")
    <main id="Home">
        @include('website::layouts.parts.search')
        <section class="car-type-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-header-title">
                        <h3>{{app('settings')->get('car_types_title')}}</h3>
                        <div class="black-line"></div>
                        <a href="{{LaravelLocalization::getLocalizedURL(null, route('website.cars.types.index')) }}" class="view-all-btn">{{__('lang.View All')}}</a>
                    </div>
                    <div class="description-container">
                        <p class="description-text">
                            {{app('settings')->get('car_types_description')}}
                        </p>
                        <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                    </div>
                </div>
            </div>
            <div class="choose-fav-car-slider-wrapper container">
                <span href="" class=" choose-fav-car-type-prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
                <div class="container choose-fav-car-type-slider">
                    @foreach($types as $item)
                        @if ($item->slug == 'yachts')
                            <a class="car-type-brand-slide" href="{{LaravelLocalization::getLocalizedURL(null, route('website.yachts.index')) }}">
                                <picture>
                                    <img alt="{{$item->slug}}" src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($item->image)}}">
                                </picture>
                                <div class="car-type-brand-slide-footer">
                                    <p>{{$item->title}}</p>
                                </div>
                            </a>
                            @continue
                        @endif
                        <a class="car-type-brand-slide" href="{{LaravelLocalization::getLocalizedURL(null, route('website.cars.types.show', ['type' => $item])) }}">
                            <picture>
                                <img alt="{{$item->slug}}" src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($item->image)}}">
                            </picture>
                            <div class="car-type-brand-slide-footer">
                                <p>{{$item->title}}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <span href="#" class=" choose-fav-car-type-next">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </div>
        </section>

        <section class="car-brand-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-header-title">
                        <h3>{{app('settings')->get('car_brands_title')}}</h3>
                        <div class="black-line"></div>
                        <a href="{{LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.index')) }}" class="view-all-btn">{{__('lang.View All')}}</a>
                    </div>
                    <div class="description-container">
                        <p class="description-text">
                            {{app('settings')->get('car_brands_description')}}
                        </p>
                        <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                    </div>
                </div>
            </div>
            <div class="choose-fav-car-slider-wrapper container">
                <span href="" class=" choose-fav-car-brand-prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
                <div class="container choose-fav-car-brand-slider">
                    @foreach(app('cars')->brands as $item)
                        <a class="car-type-brand-slide" href="{{LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.show', ['brand' => $item])) }}">
                            <picture>
                                <img alt="{{$item->slug}}" src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($item->image)}}">
                            </picture>
                            <div class="car-type-brand-slide-footer">
                                <p>{{$item->title}}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <span href="#" class=" choose-fav-car-brand-next">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </div>
        </section>


        @foreach($sections as $index => $section)
            @include('website::layouts.parts.section', ['section' => $section])
        @endforeach


        @include('website::layouts.parts.banners',[
            "banners" => $banners
        ])

        <section>
            <div class="container home-main-boxes-topic">
                <h3>{{app('settings')->get('find_your_car_title')}}</h3>
                <p>{{app('settings')->get('find_your_car_description')}}</p>
            </div>
            <div class="container home-main-boxes">
                <div class="home-main-box">
                    <div>
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <h4>{{__('lang.Find Car')}}</h4>
                    <p>{{__('lang.Select a car using search or catalog.')}}</p>
                </div>
                <picture>
                    <img src="{{asset('/assets/images/chveron dashed top.png')}}" alt="">
                </picture>
                <div class="home-main-box">
                    <div>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <h4>{{__('lang.Contact Your Dealer')}}</h4>
                </div>
                <picture>
                    <img src="{{asset('/assets/images/chevron dashed bottom.png')}}" alt="">
                </picture>
                <div class="home-main-box">
                    <div>
                        <i class="fa-regular fa-square-check"></i>
                    </div>
                    <h4>{{__('lang.Get Your Car')}}</h4>
                </div>
            </div>
        </section>
        <hr class="mt-5">

        @if (($left = app('settings')->get('book_your_next_trip_left')) && ($right = app('settings')->get('book_your_next_trip_right')))
            <section class="booking-stpes-section">
                <picture>
                    <img src="{{asset('/assets/images/FerariF8TributoRedK2930FrontDet.png')}}" alt="">
                </picture>
                <div class="container booking-steps-content">
                    <div>
                        {!! $left !!}
                    </div>
                    <div>
                        {!! $right !!}
                    </div>
                </div>
            </section>
        @endif

        @include('website::layouts.parts.content', [
            "content" => \App\Models\Content::where('type','home')->first()
        ])


        @if(app('settings')->get('google_reviews_widget'))
            <section>
                <div class="container testimonials-container">
                    <h4>{{__('lang.Testimonials')}}</h4>
                    <h2>{{__('lang.Google Reviews')}}</h2>
                    <div class="row">
                        <div class="col-lg-12 gr" data-item="{{app('settings')->get('google_reviews_widget')}}">
                        </div>
                    </div>
                </div>
        </section>
        @endif

        @if(app('settings')->get('facebook_reviews_widget'))
        <section class="home__google_reviews">
            <div class="container testimonials-container">
                <h4>{{__('lang.Testimonials')}}</h4>
                <h2>{{__('lang.Facebook Reviews')}}</h2>
                <div class="row">
                    <div class="col-lg-12 fb" data-item="{{app('settings')->get('facebook_reviews_widget')}}">
                    </div>
                </div>
            </div>
        </section>
        @endif

        @include('website::layouts.parts.faq', [
            "faq" => \App\Models\Faq::where('type','home')->get()
        ])
    </main>
@endsection


@section("js")
    <script>
        $(function (){
            $('.choose-fav-car-type-slider').slick({
                infinite: false,
                slidesToShow: 6,
                  slidesToScroll: 1,
                  swipeToSlide: true,
                  waitForAnimate: false,
                  speed: 200,
                  touchThreshold: 8,
                dots: false,
                arrows: true,
                @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
                nextArrow: $(".choose-fav-car-type-next"),
                prevArrow: $(".choose-fav-car-type-prev"),
                autoplay: false,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 991.89,
                        settings: {
                            slidesToShow: 2
                        },
                    },
                    {
                        breakpoint: 767.89,
                        settings: {
                            slidesToShow: 2
                        },

                    },
                    {
                        breakpoint: 576.89,
                        settings: {
                            slidesToShow: 2
                        },
                    },
                ]
            });
            $('.choose-fav-car-brand-slider').slick({
                infinite: false,
                slidesToShow: 6,
  slidesToScroll: 1,
  swipeToSlide: true,
  waitForAnimate: false,
  speed: 200,
  touchThreshold: 8,
                dots: false,
                arrows: true,
                                @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
                nextArrow: $(".choose-fav-car-brand-next"),
                prevArrow: $(".choose-fav-car-brand-prev"),
                autoplay: false,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 991.89,
                        settings: {
                            slidesToShow: 2,
                            focusOnSelect: true
                        },
                    },
                    {
                        breakpoint: 767.89,
                        settings: {
                            slidesToShow: 2,
                            focusOnSelect: true
                        },

                    },
                    {
                        breakpoint: 576.89,
                        settings: {
                            slidesToShow: 2,
                            focusOnSelect: true
                        },
                    },
                ]
            });
            $('.rent-car-slider').each(function (index, element) {
                var $slider = $(element);
                var $parent = $slider.closest('.rent-car-slider-wrapper'); // Find the parent wrapper
                var $nextArrow = $parent.find('.rent-car-next');
                var $prevArrow = $parent.find('.rent-car-prev');

                $slider.slick({
                    infinite: false,
                    slidesToShow: 3,
  slidesToScroll: 1,
  swipeToSlide: true,
  waitForAnimate: false,
  speed: 200,
  touchThreshold: 8,                    dots: false,
                    arrows: true,
                    nextArrow: $nextArrow,
                    prevArrow: $prevArrow,
                    autoplay: false,
                    autoplaySpeed: 3000,
                                    @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
                    responsive: [
                        {
                            breakpoint: 991.89,
                            settings: {
                                slidesToShow: 1,
                                arrows: false,
                            },
                        },
                        {
                            breakpoint: 767.89,
                            settings: {
                                slidesToShow: 1,
                                arrows: false,
                            }
                        },
                        {
                            breakpoint: 424.89,
                            settings: {
                                slidesToShow: 1,
                                arrows: false,
                            }
                        }
                    ]
                });
            });
            $('.banner-slider-desktop').slick({
                infinite: false,
                slidesToShow: 1,
  slidesToScroll: 1,
  swipeToSlide: true,
  waitForAnimate: false,
  speed: 200,
  touchThreshold: 8,                dots: false,
                arrows: true,
                nextArrow: $(".banner-next-desktop"),
                prevArrow: $(".banner-prev-desktop"),
                                @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
                autoplay: false,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1399.89,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                    {
                        breakpoint: 991.89,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ]
            });
            $('.banner-slider-mobile').slick({
                infinite: false,
                slidesToShow: 1,
  slidesToScroll: 1,
  swipeToSlide: true,
  waitForAnimate: false,
  speed: 200,
  touchThreshold: 8,                dots: false,
                arrows: true,
                nextArrow: $(".banner-next-mobile"),
                prevArrow: $(".banner-prev-mobile"),
                                @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
                autoplay: false,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1399.89,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                    {
                        breakpoint: 991.89,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ]
            });
            $('.testimonials-slider').slick({
                infinite: false,
                slidesToShow: 4,
                  slidesToScroll: 1,
                  swipeToSlide: true,
                  waitForAnimate: false,
                  speed: 200,
                  touchThreshold: 8,
                dots: false,
                arrows: true,
                nextArrow: $(".testimonials-next"),
                prevArrow: $(".testimonials-prev"),
                                @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
                autoplay: false,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1399.89,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                    {
                        breakpoint: 991.89,
                        settings: {
                            dots: true,
                            slidesToShow: 2.3,
                        },
                    },
                    {
                        breakpoint: 767.89,
                        settings: {
                            slidesToShow: 1.5,
                            dots: true,
                        },
                    },
                    {
                        breakpoint: 424.89,
                        settings: {
                            slidesToShow: 1,
                            dots: true,
                        },
                    },

                ]
            });
        });
    </script>
@endsection

@section('schemas')
    <script type="application/ld+json">
        @php
            $data = [
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => \App\Models\Faq::whereType('home')->get()->map(function ($faq){
                    return [
                        "@type" => "Question",
                        "name" => $faq->question,
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => $faq->answer
                        ]
                    ];
                })
            ]
        @endphp
        @json($data)
    </script>
@endsection