<section class="home-1st-section">
    <picture>
        <img alt="search" src="{{ asset("/website/images/search_bg.webp") }}">
    </picture>
    <form action="{{LaravelLocalization::getLocalizedURL(null, route('website.cars.filter'))}}" method="get">
        <h1 class="text-white text-center">
            {{__('lang.Rent a Car in')}} {{app('country')->getCity()->title}}
        </h1>
        <p class="text-white text-center ">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque doloribus, dolore id atque ipsa sequi
            dicta eum
            temporibus suscipit repudiandae aliquid sunt corrupti et, quasi ad facilis? Tempore, reprehenderit
            eum!
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