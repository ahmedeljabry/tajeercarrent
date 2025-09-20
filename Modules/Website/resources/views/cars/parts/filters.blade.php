@php use App\Models\Brand; @endphp
@php use App\Models\Models; @endphp
@php use App\Models\Year; @endphp
@php use App\Models\Color; @endphp
@php use App\Models\Type; @endphp
@php use App\Helpers\WebpImage; @endphp
<section class="rental-section mt-5">
    <div class="container rental-section-container">
        <div class="filter-container mb-5">
            <div class="close-btn">
                <i class="fa-solid fa-xmark"></i>
            </div>

            @if (request()->routeIs('website.cars.filter'))
                <h1>
                    {{__('lang.Filter')}}
                </h1>
            @else
                <h3>
                    {{__('lang.Filter')}}
                </h3>
            @endif
            <h5 class="fw-normal">
                {{__('lang.SEARCH YOUR CAR')}}
            </h5>
            <div class="filter-box mb-4">
                <div class="filter-box-inputs d-flex flex-column gap-2 mb-3 ">
                    <div class="sort-filter flex-column  d-flex  gap-3 mb-4">
                        <div class="form-group search-filter-keyword">
                            <input value="{{request()->get('search')}}" type="text" name="search" class="form-control"
                                   placeholder="{{__('lang.Search here')}}">
                        </div>
                        <select class="form-select select-brand" name="brand">
                            <option value="">{{__('lang.Brand')}}</option>
                            @foreach(Brand::all() as $brand)
                                <option @selected(request()->get('brand') == $brand->slug || (isset($resource_type) && $resource_type == "brand" && $resource->slug == $brand->slug)) value="{{$brand->slug}}">{{$brand->title}}</option>
                            @endforeach
                        </select>
                        @if(request()->get('brand') || (isset($resource_type) && $resource_type == "brand") || (isset($resource_sub_type) && $resource_sub_type === "models"))
                            <div class="form-group">
                                @if ($brand = request()->get('brand'))
                                    <select class="form-select" name="model">
                                        <option value="">{{__('lang.Model')}}</option>
                                        @foreach(Models::where('brand_id', Brand::whereSlug($brand)->first()->id)->get() as $model)
                                            <option @selected(request()->get('model') == $model->slug) value="{{$model->slug}}">{{$model->title}}</option>
                                        @endforeach
                                    </select>
                                @elseif(isset($resource) && $resource_type == "brand")
                                    <select class="form-select" name="model">
                                        <option value="">{{__('lang.Model')}}</option>
                                        @foreach(Models::where('brand_id', $resource->id)->get() as $model)
                                            <option @selected(request()->get('model') == $model->slug) value="{{$model->slug}}">{{$model->title}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @endif
                        @if (request()->get('section'))
                            <select class="form-select select-section" name="section">
                                <option value="">{{__('lang.Section')}}</option>
                                @foreach(\App\Models\Section::all() as $section)
                                    <option @selected(request()->get('section') == $section->id) value="{{$section->id}}">{{$section->title}}</option>
                                @endforeach
                            </select>
                        @endif
                        <select class="form-select" name="year">
                            <option value="">{{__('lang.Year')}}</option>
                            @foreach(Year::all() as $year)
                                <option @selected(request()->get('year') == $year->title) value="{{$year->title}}">{{$year->title}}</option>
                            @endforeach

                        </select>

                        <select class="form-select" name="color">
                            <option value="">{{__('lang.Color')}}</option>
                            @foreach(Color::all() as $color)
                                <option @selected(request()->get('color') == $color->slug) value="{{$color->slug}}">{{$color->title}}</option>
                            @endforeach
                        </select>
                        <div class="form-group type__filter">
                            <p>{{__("lang.Type")}}</p>
                            <ul>
                                @foreach(Type::whereNotIn('slug', ['with-driver', 'yachts'])->get() as $type)
                                    <li class="filter-btn @if(in_array($type->slug, $selected_types)) active @endif">
                                        <input @checked(in_array($type->slug, $selected_types)) type="checkbox"
                                               name="types[]" value="{{$type->slug}}">
                                        {{$type->title}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="price-range-container">
                            <h3>@lang('lang.PRICE RANGE')</h3>
                            <div class="slider-wrapper">
                                <div class="slider-track"></div>

                                <!-- Left slider: only 0 → half -->
                                <input type="range"
                                       id="minRange"
                                       min="0"
                                       max="{{ $max_price / 2 - 10}}"
                                       value="{{ request('min_price', 0) }}"
                                       step="10"
                                       name="min_price">

                                <!-- Right slider: only half → max -->
                                <input type="range"
                                       id="maxRange"
                                       min="{{ $max_price / 2 + 10 }}"
                                       max="{{ $max_price }}"
                                       value="{{ request('max_price', $max_price) }}"
                                       step="10"
                                       name="max_price">
                            </div>

                            <div class="price-values">
                                <span id="minValue">0 {{ app('currencies')->getCurrency()->code }}</span>
                                <span id="maxValue">{{ $max_price }} {{ app('currencies')->getCurrency()->code }}</span>
                            </div>
                        </div>

                        <button type="submit" class="main-btn rounded-0 ">
                            {{__('lang.Find Car')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="filter-btn-mobile d-flex align-items-center gap-2">
    <i class="fa-solid fa-filter"></i>
    {{__('lang.Filter')}}
</div>

@section('schemes')
    @if(count($cars) > 0)
        @foreach($cars as $car)
            <script type="application/ld+json">{
            "@context": "https://schema.org",
            "@type": ["AutoRental","Product", "Car"],
            "name": "{{$car->name}}",
            "telephone": "{{app('settings')->get('contact_phone')}}",
             "priceRange": "AED 0-{{$max_price}}",
            "vehicleIdentificationNumber": "{{substr(md5($car->id) , 0 , 17)}}",
            "vehicleModelDate": "{{$car->year ? $car->year->title : '2021'}}",
            "image": [
                "{{secure_url('/')}}/storage/{{WebpImage::generateUrl($car->image)}}"
            ],
            "url": "{{LaravelLocalization::getLocalizedURL(null, route('website.cars.show', ['car' => $car]))}}",
            "offers": {
                "@type": "Offer",
                "availability": "https://schema.org/InStock",
                "price": "{{ $car->price_per_day }}",
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
swipeToSlide: true, waitForAnimate: false, touchThreshold: 5,
                dots: false,
                arrows: true,
                nextArrow: $nextArrow,
                prevArrow: $prevArrow,
                                @if (app()->getLocale() == "ar")
                    rtl: true,
                @endif
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
        })
    </script>

    <script>
        $(function (){
            $('.filter-btn').on('click', function (){
                $(this).toggleClass('active');
                $(this).find('input[type=checkbox]').prop('checked', false);
                if ($(this).hasClass('active')){
                    $(this).find('input[type=checkbox]').prop('checked', true);
                    return;
                }
            })
        });
    </script>
    <script>
        const minRange = document.getElementById("minRange");
        const maxRange = document.getElementById("maxRange");
        const minValueDisplay = document.getElementById("minValue");
        const maxValueDisplay = document.getElementById("maxValue");
        const track = document.querySelector(".slider-track");
        const maxPrice = {{ $max_price }};
        const halfPrice = maxPrice / 2;

        function updateRange() {
            let minVal = parseInt(minRange.value, 10);
            let maxVal = parseInt(maxRange.value, 10);


            // Update labels
            minValueDisplay.textContent = `${minVal.toLocaleString()} {{ app('currencies')->getCurrency()->code }}`;
            maxValueDisplay.textContent = `${maxVal.toLocaleString()} {{ app('currencies')->getCurrency()->code }}`;

            // Update track fill
            const minPercent = (minVal / maxPrice) * 100;
            const maxPercent = (maxVal / maxPrice) * 100;

            console.log(minPercent, maxPercent)

            track.style.background = `linear-gradient(to right,
        #ddd 0%,
        #ddd ${minPercent}%,
        #A2E2FF ${minPercent}%,
        #A2E2FF ${maxPercent}%,
        #ddd ${maxPercent}%,
        #ddd 100%)`;
        }

        minRange.addEventListener("input", updateRange);
        maxRange.addEventListener("input", updateRange);

        // Initialize once
        updateRange();
    </script>

    <script>
        $(function (){
            $('.order-by').on('change', function(){
                $(this).closest('form').submit();
            });
        });


        $(document).ready(function () {
            $('.filter-btn-mobile').on('click', function () {
                $('.filter-container').addClass('show');
                $("body").addClass('overflow-hidden').css('height', '100vh');
            });

            $('.close-btn').on('click', function () {
                $('.filter-container').removeClass('show');
                $("body").removeClass('overflow-hidden');
            });
        });
    </script>
@endsection