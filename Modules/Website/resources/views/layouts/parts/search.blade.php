<section class="home-1st-section">
    <picture>
        <img alt="search" src="{{ asset("/assets/images/FerariF8TributoRedK2930InteriorFront.png") }}">
    </picture>
    <form action="{{LaravelLocalization::getLocalizedURL(null, route('website.cars.filter'))}}" method="get">
        <h1 class="text-white text-center">
            {{__('lang.Rent a Car in')}} {{ optional(app('country')->getCity())->title }}
        </h1>
        <p class="text-white text-center ">
            {!! app('settings')->get('homepage_banner') !!}
        </p>
        <div class="view-all-cars-input">
            <button>
                <div class="icon-view">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <div class="views-content d-flex flex-column flex-md-row  gap-0 gap-md-1 ">
                    <span>{{__('lang.View all cars')}}</span>
                </div>
            </button>
            <input name="search" placeholder="{{__('lang.Search here')}}" type="text"/>
        </div>
    </form>
</section>
