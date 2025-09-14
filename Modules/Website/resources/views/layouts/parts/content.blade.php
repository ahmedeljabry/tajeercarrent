    @if($content)
        @if($content->title || $content->description || $content->image)
            <section class="home-content-section">
                <div class="container">
                    <picture>
                        <img loading="lazy" alt="{{$content->title}}" src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($content->image)}}" />
                    </picture>
                    <div class="home-content-container">
                        <div class="home-desc">
                            <h2>{{$content->title}}</h2>
                            {!! $content->description !!}
                        </div>
                        <div class="main-btn">{{__('lang.Read More')}}</div>
                    </div>
                </div>
            </section>
            <hr>
        @endif

        @if($content->title_2 || $content->description_2 || $content->image_2)
            <section class="home-content-section">
                <div class="container">
                    <picture>
                        <img loading="lazy" alt="{{$content->title_2}}" src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($content->image_2)}}" />
                    </picture>
                    <div class="home-content-container">
                        <div class="home-desc">
                            <h2>{{$content->title_2}}</h2>
                            {!! $content->description_2 !!}
                        </div>
                        <div class="main-btn">{{__('lang.Read More')}}</div>
                    </div>
                </div>
            </section>
            <hr>
        @endif

        @if($content->title_3 || $content->description_3 || $content->image_3)
            <section class="home-content-section">
                <div class="container">
                    <picture>
                        <img loading="lazy" alt="{{$content->title_3}}" src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($content->image_3)}}" />
                    </picture>
                    <div class="home-content-container">
                        <div class="home-desc">
                            <h2>{{$content->title_3}}</h2>
                            {!! $content->description_3 !!}
                        </div>
                        <div class="main-btn">{{__('lang.Read More')}}</div>
                    </div>
                </div>
            </section>
            <hr>
        @endif
    @endif
