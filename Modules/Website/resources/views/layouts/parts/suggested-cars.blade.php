@if (count($suggested_cars) > 0)
    <section class="mb-5">
        <div class="container">
            <div class="section-header">
                <div class="section-header-title">
                    <h3>{{__('lang.Featured Cars')}}</h3>
                    <div class="black-line"></div>
                </div>
            </div>
        </div>
        <div class="rent-car-slider-wrapper container">
                <span href="" class=" rent-car-prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            <div class="rent-car-slider container">
                @foreach($suggested_cars as $car)
                    @include('website::layouts.parts.car', ['car' => $car])
                @endforeach
            </div>
            <span href="" class=" rent-car-next">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
        </div>
    </section>
    <hr>
@endif