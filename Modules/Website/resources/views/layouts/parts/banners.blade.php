    @if(count($banners) > 0)
        <section class="d-none d-lg-block ">
            <div class="container banner-slider-wrappper ">
                <span href="#" class=" banner-prev-desktop">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
                <div class="banner-slider-desktop container">
                    @foreach($banners as $banner)
                        <div>
                            <a href="{{$banner->link}}">
                                <picture>
                                    <img src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($banner->image)}}" alt="{{ $banner->image }}">
                                </picture>
                            </a>
                        </div>
                    @endforeach
                </div>
                <span href="#" class=" banner-next-desktop">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </div>
        </section>
        <section class="d-block d-lg-none">
            <div class="container banner-slider-wrappper ">
                <span href="#" class=" banner-prev-mobile">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
                <div class="banner-slider-mobile container">
                    @foreach($banners as $banner)
                        <div>
                            <a href="{{$banner->link}}">
                                <picture>
                                    <img src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($banner->image)}}" alt="{{ $banner->image }}">
                                </picture>
                            </a>
                        </div>
                    @endforeach
                </div>
                <span href="#" class=" banner-next-mobile">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </div>
        </section>
    @endif

