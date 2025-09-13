@extends('website::layouts.master')

@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => \App\Models\SEO::where('type','yacht')->first(),
        "title" => app('settings')->get('yacht_title'),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection

@section('css')
    <link href="{{asset('/css/rent.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section("content")
    <main id="rent">
        @include('website::layouts.parts.page-banner', [
            "title" => app('settings')->get('yacht_title') ?? __('lang.Rent yacht')
        ])

        @include('website::cars.parts.breadcrumb',[
            'breadcrumbs' => [
                app('settings')->get('yacht_title') ?? __('lang.Rent a car with driver') => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.yachts.index'))
            ]
        ])

        <section class="mb-5">
            <div class="container">
                <div class="section-header">
                    <div class="section-header-title">
                        <h1>{{app('settings')->get('yacht_title')}}</h1>
                        <div class="black-line"></div>
                    </div>
                    <div class="description-container">
                        <p class="description-text">
                            {!! app('settings')->get('yacht_description') !!}
                        </p>
                        <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                    </div>
                </div>
            </div>
            <div class="rent-car-slider-wrapper container">
                <div class="rent-car-slider rent-container-section container">
                    @foreach($yachts as $yacht)
                        @include('website::yachts.parts.yacht', ['car' => $yacht])
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                {{$yachts->appends(request()->input())->links()}}
            </div>
        </section>
        <hr>
        @include('website::layouts.parts.content', [
            "content" => \App\Models\Content::where('type','yacht')->first()
        ])

        @include('website::layouts.parts.faq', [
            "faq" => \App\Models\Faq::where('type','yacht')->get()
        ])
    </main>
@endsection

@section('schemes')
        @if(count($yachts) > 0)
            @foreach($yachts as $yacht)
                <script type="application/ld+json">{
            "@context": "https://schema.org",
            "@type": ["AutoRental","Product", "Yacht"],
            "name": "{{$yacht->name}}",
            "telephone": "{{app('settings')->get('contact_phone')}}",
             "priceRange": "AED 100-60000",
            "vehicleIdentificationNumber": "{{substr(md5($yacht->id) , 0 , 17)}}",
            "vehicleModelDate": "{{$yacht->year ? $yacht->year->title : '2021'}}",
            "image": [
                "{{secure_url('/')}}/storage/{{\App\Helpers\WebpImage::generateUrl($yacht->image)}}"
            ],
            "url": "{{route('website.yachts.show', ['yacht' => $yacht])}}",
            "offers": {
                "@type": "Offer",
                "availability": "https://schema.org/InStock",
                "price": "{{ isset($yacht->price_per_day) && $yacht->price_per_day > 0 ? $yacht->price_per_day   : 100}}",
                "priceCurrency": "AED",
                "priceValidUntil": "2025-12-31"
            },
            "itemCondition": "https://schema.org/NewCondition",
            "model": "{{$yacht->model ? $yacht->model->title : 'Model'}}",
            "brand": "{{$yacht->brand ? $yacht->brand->title : 'Brand'}}",
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
                    "reviewBody": "{{$yacht->description}}",
                    "name": "{{$yacht->name}}",
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
             "vehicleInteriorColor": "{{ $yacht?->color?->title ?? 'White' }}",
              "numberOfDoors": {{ $yacht?->doors ?? 2 }},
              "bodyType": "Pickup",
              "vehicleInteriorType": "Standard",
              "driveWheelConfiguration": "https://schema.org/FourWheelDriveConfiguration",
              "vehicleSeatingCapacity": {{ $yacht?->passengers ?? 2 }},
              "color": "{{ $yacht?->color?->title ?? 'White' }}"
            }
                </script>
            @endforeach
        @endif

    @endsection
