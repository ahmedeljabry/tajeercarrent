    @if($section->cars()->whereHas('company', function($q) {
        $q->where('country_id', app('country')->getCountry()->id);
    })->count() > 0)
        <section>
            <div class="container">
                <div class="section-header">
                    <div class="section-header-title">
                        <h3>{{$section->title}}</h3>
                        <div class="black-line"></div>
                        <a href="{{route('website.cars.filter', ['section' => $section->id])}}" class="view-all-btn">{{__('lang.View All')}}</a>
                    </div>
                    <div class="description-container">
                        <p class="description-text">
                            {{$section->description}}
                        </p>
                        <button type="button" class="read-more-btn">{{__('lang.Read More')}}</button>
                    </div>
                </div>
            </div>
            <div class="rent-car-slider-wrapper container">
                <span href="#" class=" rent-car-prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
                <div class="rent-car-slider container">
                    @foreach($section->cars()->whereHas('company', function ($q){
                        $q->where('country_id', app('country')->getCountry()->id);
                    })->orderBy('refreshed_at', 'desc')->limit(10)->get() as $car)
                        @include('website::layouts.parts.car', ['car' => $car])
                    @endforeach
                </div>
                <span href="#" class=" rent-car-next">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </div>
        </section>
    @endif
