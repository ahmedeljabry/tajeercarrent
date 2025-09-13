@extends('website::layouts.master')

@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => \App\Models\SEO::where('type','driver')->first(),
        "title" => app('settings')->get('driver_title'),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection

@section('css')
    <link href="{{asset('/css/rent.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section("content")
    <main id="rent">
        @include('website::layouts.parts.page-banner', [
            "title" => app('settings')->get('driver_title') ?? __('lang.Rent a car with driver')
        ])

        @include('website::cars.parts.breadcrumb',[
            'breadcrumbs' => [
                app('settings')->get('driver_title') ?? __('lang.Rent a car with driver') => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.cars.with-drivers'))
            ]
        ])

        <section class="mb-5">
            <div class="container">
                <div class="section-header">
                    <div class="section-header-title">
                        <h3>{{app('settings')->get('driver_title')}}</h3>
                        <div class="black-line"></div>
                    </div>
                    <div class="description-container">
                        <p class="description-text">
                            {!! app('settings')->get('driver_description') !!}
                        </p>
                        <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                    </div>
                </div>
            </div>
            <div class="rent-car-slider-wrapper container">
                <div class="rent-car-slider rent-container-section container">
                    @foreach($cars as $car)
                        @include('website::layouts.parts.car', ['car' => $car])
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                {{$cars->appends(request()->input())->links()}}
            </div>
        </section>
        <hr>
        @include('website::layouts.parts.content', [
            "content" => \App\Models\Content::where('type','driver')->first()
        ])

        @include('website::layouts.parts.faq', [
            "faq" => \App\Models\Faq::where('type','driver')->get()
        ])
    </main>
@endsection

@section('schemes')
        @if(count($cars) > 0)
            @foreach($cars as $car)
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
            "url": "{{route('website.cars.show', ['car' => $car])}}",
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
                    "reviewBody": "{{$car->description}}",
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
            @endforeach
        @endif

    @endsection

@section('js')

@endsection
