@extends('website::layouts.master')
@section('css')
    <link href="{{asset('/css/car-details.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => $car->model ? \App\Models\SEO::where('type','model')->where('resource_id', $car->model->id)->first() : null,
        "title" => $car->name . "-" .  ( $car->company?->name ??  ''  ) . " #" .   $car->id ,
        "image" => secure_url('/') . '/storage/'. \App\Helpers\WebpImage::generateUrl($car->image)
    ])
@endsection
@section("content")
    <main id="car-details">
        <section class="car-details-section">
            @include('website::cars.parts.breadcrumb', [
                'breadcrumbs' => [
                    app('settings')->get('page_car_brands_title') ?: __('lang.Car Brands') => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.index')),
                    $car->brand->title => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.show', ['brand' => $car->brand])),
                    $car->name => null
            ]])
            <div class="section-header container mb-5">
                <div class="section-header-title">
                    <h3>{{$car->name}}</h3>
                    <div class="black-line"></div>
                    <a href="{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.show', ['brand' => $car->brand]))}}" class="view-all-btn">{{__('lang.View All')}}</a>
                </div>
                <div class="description-container">
                    <p class="description-text">
                        {!! $car->getDescription() !!}
                    </p>
                    <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                </div>
            </div>
            <div class="container m-auto ">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="car-details-slider">
                            <div class="slider-for-car-details">
                                @foreach($car->images as $image)
                                    <img class="mw-100 " src="/storage/{{\App\Helpers\WebpImage::generateUrl($car->image)}}" alt="{{$car->name}}">
                                @endforeach
                            </div>
                            <div class="slider-nav-car-details my-5 ">
                                @foreach($car->images as $image)
                                    <img class="mw-100 " src="/storage/{{\App\Helpers\WebpImage::generateUrl($car->image)}}" alt="{{$car->name}}">
                                @endforeach
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="car-details-pricing">
                            <h3 class="text-center ">{{__('lang.Price')}}</h3>
                            <div class="car-details-pricing-group d-flex justify-content-between ">
                                @if($car->price_per_day)
                                    <div class="car-details-pricing-card">
                                        <h4 class="text-center">{{__('lang.Day')}}</h4>
                                        <ul>
                                            <li>
                                                {{app('currencies')->convert($car->price_per_day)}} {{app('currencies')->getCurrency()->code}}
                                            </li>
                                            <li>
                                                {{__('lang.KM Limit Day')}} / {{$car->km_per_day ?: 250}} {{__('lang.KM')}}
                                            </li>
                                            @if ($car->extra_price)
                                                <li>
                                                    {{__('lang.Extra KM Price')}} = {{app('currencies')->convert($car->extra_pric)}} {{app('currencies')->getCurrency()->code}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if($car->price_per_week)
                                    <div class="car-details-pricing-card">
                                        <h4 class="text-center">{{__('lang.Day')}}</h4>
                                        <ul>
                                            <li>
                                                {{app('currencies')->convert($car->price_per_week)}} {{app('currencies')->getCurrency()->code}}
                                            </li>
                                            <li>
                                                {{__('lang.KM Limit Week')}} / {{$car->km_per_week ?: 250}} {{__('lang.KM')}}
                                            </li>
                                            @if ($car->extra_price)
                                                <li>
                                                    {{__('lang.Extra KM Price')}} = {{app('currencies')->convert($car->extra_pric)}} {{app('currencies')->getCurrency()->code}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                @if($car->price_per_month)
                                    <div class="car-details-pricing-card">
                                        <h4 class="text-center">{{__('lang.Day')}}</h4>
                                        <ul>
                                            <li>
                                                {{app('currencies')->convert($car->price_per_month)}} {{app('currencies')->getCurrency()->code}}
                                            </li>
                                            <li>
                                                {{__('lang.KM Limit Day')}} / {{$car->km_per_month ?: 250}} {{__('lang.KM')}}
                                            </li>
                                            @if ($car->extra_price)
                                                <li>
                                                    {{__('lang.Extra KM Price')}} = {{app('currencies')->convert($car->extra_pric)}} {{app('currencies')->getCurrency()->code}}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="car-details-pricing-deposit">
                                <p>
                                    Deposit / Not required
                                </p>
                            </div>
                        </div>
                        @if (app('settings')->get($car->type . "_notes"))
                            <div class="car-details-notes my-5">
                                <div class="head-title-with-line">
                                    <h3>{{__('lang.Please Note')}}</h3>
                                </div>
                                <div class="ms-1">
                                    {!! app('settings')->get($car->type . "_notes") !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="car-details-features py-5 py-lg-0 ">
                            <h1>
                                {{$car->name}}
                            </h1>
                            <div class="car-details-feat d-flex flex-column flex-md-row flex-wrap  gap-5">
                                <ul>
                                    <li>
                                        {{__('lang.Brand')}} / {{$car->brand->title}}
                                    </li>
                                    <li>
                                        {{__('lang.Model')}} / {{$car->model->title}}
                                    </li>
                                    <li>
                                        {{__('lang.Year')}} / {{$car->year->title}}
                                    </li>
                                    <li>
                                        {{__('lang.Color')}}/ {{$car->color->title}}
                                    </li>
                                    <li>
                                        {{__('lang.Type')}}: {{$car->types->map(function($type){return $type;})->implode(', ')}}
                                    </li>
                                    <li>
                                        {{__('lang.Doors')}} / {{$car->doors}}
                                    </li>
                                    <li>
                                        {{__('lang.Passengers')}} / {{$car->passengers}}
                                    </li>
                                    <li>
                                        {{__('lang.No. Of Luggage')}} / {{$car->bags}}
                                    </li>
                                    <li>{{__('lang.Insurance Type')}} / {{__('lang.Full')}} </li>
                                </ul>
                                <ul>
                                    <li>{{__("lang.Minimum of Days")}} /  {{$car->minimum_day_booking}}</li>
                                    <li>{{__('lang.Deposit')}} / {{app('currencies')->convert($car->security_deposit)}} {{app('currencies')->getCurrency()->code}}</li>
                                    <li>
                                        {{__('lang.KM Limit Day')}} / {{$car->km_per_day ?: 250}} {{__('lang.KM')}}
                                    </li>
                                    <li>
                                        {{__('lang.KM Limit Week')}} / {{$car->km_per_week ?: 250}} {{__('lang.KM')}}
                                    </li>
                                    <li>
                                        {{__('lang.KM Limit Day')}} / {{$car->km_per_month ?: 250}} {{__('lang.KM')}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="rent-car-slide-footer social-media-icons">
                            <a href="https://wa.me/{{str_replace(['+', ' '], '', app('settings')->get('contact_phone'))}}?text={{urlencode("Hello I Am Interested On This Car, " . LaravelLocalization::getLocalizedUrl(null, route('website.cars.show', ['car' => $car])))}}" target="_blank" rel="noopener">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24">
                                        <g>
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path fill-rule="nonzero"
                                                  d="M2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308a.961.961 0 0 0-.371.1 1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.729 2.729 0 0 0 6.9 9.62c.002.49.13.967.33 1.413.409.902 1.082 1.857 1.971 2.742.214.213.423.427.648.626a9.448 9.448 0 0 0 3.84 2.046l.569.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231c.166-.088.244-.132.383-.22 0 0 .043-.028.125-.09.135-.1.218-.171.33-.288.083-.086.155-.187.21-.302.078-.163.156-.474.188-.733.024-.198.017-.306.014-.373-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.401-.621a.498.498 0 0 0-.177-.041.482.482 0 0 0-.378.127v-.002c-.005 0-.072.057-.795.933a.35.35 0 0 1-.368.13 1.416 1.416 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.109l-.005-.002a6.01 6.01 0 0 1-1.57-1c-.126-.11-.243-.23-.363-.346a6.296 6.296 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41a4.38 4.38 0 0 0 .263-.373c.118-.19.155-.385.093-.536-.28-.684-.57-1.365-.868-2.041-.059-.134-.234-.23-.393-.249-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <span>{{__('lang.Whatsapp')}}</span>
                            </a>
                            <a href="mailto:{{ app('settings')->get('contact_email')}}" tabindex="0">
                                <div>
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <span>{{__('lang.Email')}}</span>
                            </a>
                            <a href="tel:{{str_replace(' ', '', app('settings')->get('contact_phone'))}}" tabindex="0">
                                <div>
                                    <svg id="phone-svgrepo-com_1_" data-name="phone-svgrepo-com (1)" xmlns="http://www.w3.org/2000/svg"
                                         width="15.457" height="15.457" viewBox="0 0 15.457 15.457">
                                        <g id="Group_2510" data-name="Group 2510" transform="translate(1.562 0)">
                                            <path id="Path_1041" data-name="Path 1041"
                                                  d="M20.327,11.406a7.674,7.674,0,0,0-2.292-1.981c-.408-.233-.9-.259-1.133.156a9.3,9.3,0,0,1-.735.8,1.369,1.369,0,0,1-1.948-.193L12.739,8.712,11.26,7.233a1.369,1.369,0,0,1-.193-1.948,9.3,9.3,0,0,1,.8-.735c.414-.233.389-.725.156-1.133a7.674,7.674,0,0,0-1.981-2.292,1.013,1.013,0,0,0-1.19.179L8.2,1.957C6.129,4.029,7.149,6.369,9.222,8.442l1.894,1.894L13.01,12.23c2.072,2.072,4.412,3.093,6.485,1.02l.654-.654A1.014,1.014,0,0,0,20.327,11.406Z"
                                                  transform="translate(-6.808 -0.747)" fill="#3e1f50"></path>
                                            <path id="Path_1042" data-name="Path 1042"
                                                  d="M16.279,13.9a3.68,3.68,0,0,1-.83-.1,7.369,7.369,0,0,1-3.366-2.133L8.294,7.876A7.37,7.37,0,0,1,6.161,4.51,3.572,3.572,0,0,1,7.274,1.027L7.927.374A1.264,1.264,0,0,1,9.42.149,7.774,7.774,0,0,1,11.5,2.539a1.274,1.274,0,0,1,.168.962.855.855,0,0,1-.4.514,8.54,8.54,0,0,0-.739.668A1.115,1.115,0,0,0,10.7,6.3l2.959,2.959a1.116,1.116,0,0,0,1.622.162,8.632,8.632,0,0,0,.668-.739.855.855,0,0,1,.514-.4,1.27,1.27,0,0,1,.959.166,7.782,7.782,0,0,1,2.392,2.084h0a1.264,1.264,0,0,1-.225,1.493l-.654.653A3.7,3.7,0,0,1,16.279,13.9ZM8.825.516a.754.754,0,0,0-.533.222l-.653.654a3.05,3.05,0,0,0-.976,3,6.881,6.881,0,0,0,2,3.118L12.447,11.3a6.882,6.882,0,0,0,3.118,2,3.054,3.054,0,0,0,3-.976l.654-.653a.752.752,0,0,0,.134-.888h0A7.155,7.155,0,0,0,17.159,8.9a.79.79,0,0,0-.563-.116.346.346,0,0,0-.215.176L16.354,9a7.6,7.6,0,0,1-.789.852,1.625,1.625,0,0,1-2.275-.224L10.332,6.667a1.752,1.752,0,0,1-.558-1.519,1.782,1.782,0,0,1,.334-.755A7.6,7.6,0,0,1,10.96,3.6L11,3.577a.347.347,0,0,0,.176-.215.793.793,0,0,0-.118-.566A7.481,7.481,0,0,0,9.18.6.76.76,0,0,0,8.825.516Z"
                                                  transform="translate(-6.063 0)" fill="#3e1f50"></path>
                                        </g>
                                        <path id="Path_1043" data-name="Path 1043"
                                              d="M37.157,37.744H37.13a5.378,5.378,0,0,1-2.988-1.361.258.258,0,0,1,.361-.367,4.94,4.94,0,0,0,2.679,1.215.258.258,0,0,1-.026.514Z"
                                              transform="translate(-25.29 -26.683)" fill="#3e1f50"></path>
                                        <path id="Path_1044" data-name="Path 1044"
                                              d="M18.868,17.289a.256.256,0,0,1-.164-.059,4.92,4.92,0,0,1-1.638-3.006.258.258,0,1,1,.513-.053,4.472,4.472,0,0,0,1.453,2.661.258.258,0,0,1-.165.456Z"
                                              transform="translate(-12.669 -10.35)" fill="#3e1f50"></path>
                                        <path id="Path_1045" data-name="Path 1045"
                                              d="M.257,51.1a.263.263,0,0,1-.074-.011.258.258,0,0,1-.173-.321l.675-2.25a.36.36,0,0,1,.689,0L1.8,49.943l.428-1.427a.36.36,0,0,1,.689,0l.428,1.427.428-1.427a.36.36,0,0,1,.689,0l.428,1.427.428-1.427a.36.36,0,0,1,.689,0l.428,1.427.428-1.427a.36.36,0,0,1,.689,0l.233.776a1.81,1.81,0,0,0,3.544-.52v-.508a.258.258,0,0,1,.515,0v.508A2.325,2.325,0,0,1,7.3,49.44l-.084-.28-.428,1.427a.36.36,0,0,1-.689,0L5.667,49.16l-.428,1.427a.36.36,0,0,1-.689,0L4.121,49.16l-.428,1.427a.36.36,0,0,1-.689,0L2.576,49.16l-.428,1.427a.36.36,0,0,1-.689,0L1.03,49.16.5,50.913A.258.258,0,0,1,.257,51.1Z"
                                              transform="translate(0 -35.64)" fill="#3e1f50"></path>
                                    </svg>
                                </div>
                                <span>{{__('lang.Call')}}</span>
                            </a>
                        </div>
                        <div class="car-details-require car-details-pricing">
                            <h3 class="text-center ">{{__('lang.Details & Requirements')}}</h3>
                            <ul class="mt-3">
                                @if ($car->company->payment_methods)
                                    <li>
                                        {{__('lang.Payment Methods')}} / {{collect(explode(',', $car->company->payment_methods))->map(function ($item){return __('admin.' . $item);})->implode(', ')}}
                                    </li>
                                @endif
                                <li>
                                    <div class="times-group-container d-flex gap-2">
                                        <p>{{__('lang.Delivery Locations')}} / </p> <div class="days">{!! $car->company->cities->chunk(5)->map(function ($item){return '<p>' . $item->map(function ($item){return $item->title;})->implode(' - ') . '</p>';})->implode('') !!}</div>
                                    </div>
                                </li>
                                <li>
                                    {{__('lang.Salik Charges')}} / {{app('currencies')->convert($car->salik_fees)}} {{app('currencies')->getCurrency()->code}}
                                </li>
                                <li>
                                    {{$car->company->vat_percentage}}% {{__('lang.VAT')}} / {{__('lang.Not Included')}}
                                </li>
                                <li>
                                    {{__('lang.Age Required')}} / {{$car->company->min_age}}+
                                </li>
                                @if($car->company->type == "default")
                                    <li>
                                        {{__('admin.Deposit Refund')}} / {{$car->company->deposit_refund}} ({{__('lang.Days')}})
                                    </li>
                                @endif
                                @if ($car->company->hours()->where('type', '!=', 'holiday')->count())
                                    <li>
                                        <div class="times-group-container d-flex gap-2">
                                            <p>
                                                {{__('lang.working_hours_days')}} /
                                            </p>
                                            <div class="days">
                                                @foreach($car->company->hours()->where('type', '!=', 'holiday')->get() as $day)
                                                    <p> {{$day->day}} </p>
                                                @endforeach
                                            </div>
                                            <div class="hours">
                                                @foreach($car->company->hours()->where('type', '!=', '')->get() as $day)
                                                    @if ($day->type == "24")
                                                        <p> 24 {{__('lang.Hours')}} </p>
                                                    @elseif ($day->type == "holiday")
                                                        <p> {{__('admin.holiday')}}</p>
                                                    @else
                                                        <p>{{__('admin.from')}} {{$day->time_from->format('H:iA')}} {{__('admin.to')}} {{$day->time_to->format('H:iA')}}</p>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            {!! $car->company->terms !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if ($car->features->count() > 0)
            <section class="car-features">
                <div class="container">
                    <div class="head-title-with-line">
                        <h3>
                            {{__('lang.Features')}}
                        </h3>
                    </div>
                    <div class="row">
                        @foreach ($car->features?->split(4) as $chunk)
                            <div class="col-md-6 co-lg-4 col-xl-3 mb-4 car-details-notes">
                                <ul class="mt-2">
                                    @foreach ($chunk as $feature)
                                        <li>{{$feature->name}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @if ($features = $car?->model->page_features)
            <section class="car-description py-5">
                <div class="container">
                    <div class="head-title-with-line">
                        <h3>
                            {{$car->name}}
                        </h3>
                    </div>
                    <div class="car-content-desc mt-3">
                        {!! $features !!}
                    </div>
                </div>
            </section>
        @endif
    </main>

    @include('website::layouts.parts.suggested-cars', ['suggested_cars' => $suggested_cars])

    @include('website::layouts.parts.content', [
        "content" => \App\Models\Content::where('type','car')->where('resource_id', $car->id)->first()
    ])

    @include('website::layouts.parts.faq', [
        "faq" => \App\Models\Faq::where('type','car')->where('resource_id', $car->id)->get()
    ])


@endsection
@section('js')
    <script>
        $('.rent-car-slider').each(function (index, element) {
            var $slider = $(element);
            var $parent = $slider.closest('.rent-car-slider-wrapper'); // Find the parent wrapper
            var $nextArrow = $parent.find('.rent-car-next');
            var $prevArrow = $parent.find('.rent-car-prev');

            $slider.slick({
                infinite: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: false,
                arrows: true,
                nextArrow: $nextArrow,
                prevArrow: $prevArrow,
                responsive: [
                    {
                        breakpoint: 991.89,
                        settings: {
                            slidesToShow: 1,
                            arrows: false
                        },
                    },
                    {
                        breakpoint: 767.89,
                        settings: {
                            slidesToShow: 1,
                            arrows: false
                        }
                    },
                    {
                        breakpoint: 424.89,
                        settings: {
                            slidesToShow: 1,
                            arrows: false
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.slider-for-car-details').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav-car-details'
            });

            $('.slider-nav-car-details').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.slider-for-car-details',
                focusOnSelect: true,
                infinite: false,
            });
        });
    </script>
@endsection

@section('schemes')

        <script type="application/ld+json">{
            "@context": "https://schema.org",
            "@type": ["AutoRental","Product", "Car"],
            "name": "{{$car->name}}",
            "telephone": "{{app('settings')->get('contact_phone')}}",
             "priceRange": "AED 100-60000",
            "vehicleIdentificationNumber": "{{substr(md5($car->id) , 0 , 17)}}",
            "vehicleModelDate": "{{$car->year ? $car->year->title : '2021'}}",
            "image": [
                "{{secure_url('/')}}/storage/{{\App\Helpers\WebpImage::generateUrl($car->image)}}"
            ],
            "url": "{{secure_url('/')}}/{{$car->id}}/{{$car->slug}}",
            "offers": {
                "@type": "Offer",
                "availability": "https://schema.org/InStock",
                "price": "{{ isset($car->price_per_day) && $car->price_per_day > 0 ? $car->price_per_day   : 100}}",
                "priceCurrency": "AED",
                "priceValidUntil": "2025-12-31"
            },
            "itemCondition": "https://schema.org/NewCondition",
            "model": "{{$car->model ? $car->model->title : 'Model'}}",
            "brand": "{{$car->brand ? $car->brand->title : 'Brand'}}",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "5",
                "ratingCount": "5"
            },
            "review": [
                {
                    "@type": "Review",
                     "author": {
                        "@type": "Organization",
                        "name": "Tajeer"
                    },
                    "datePublished": "{{date('Y-m-d')}}",
                    "reviewBody": "{{$car->getDescription()}}",
                    "name": "{{$car->name}}",
                    "reviewRating": {
                        "@type": "Rating",
                        "bestRating": "5",
                        "ratingValue": "5",
                        "worstRating": "1"
                    }
                }
            ],
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "{{app('settings')->get('footer_address')}}",
                "addressLocality": "Dubai",
                "postalCode": "00000",
                "addressCountry": "AE"
              },
              "vehicleConfiguration": "ST",
              "vehicleEngine": {
                "@type": "EngineSpecification",
                "fuelType": "Gasoline"
              },
             "vehicleTransmission": "Automatic",
             "vehicleInteriorColor": "{{ $car?->color?->title ?? 'White' }}",
              "numberOfDoors": {{ $car?->doors ?? 2 }},
              "bodyType": "Pickup",
              "vehicleInteriorType": "Standard",
              "driveWheelConfiguration": "https://schema.org/FourWheelDriveConfiguration",
              "vehicleSeatingCapacity": {{ $car?->passengers ?? 2 }},
              "color": "{{ $car?->color?->title ?? 'White' }}"
            }
        </script>
@endsection
