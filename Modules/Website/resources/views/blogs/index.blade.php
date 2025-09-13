@extends('website::layouts.master')

@section('seo')
    @include('website::layouts.parts.seo', [
        "seo" => \App\Models\SEO::where('type', 'blog')->whereNull('resource_id')->first(),
        "title" => app('settings')->get('blog_title'),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection

@section('css')
    <link href="{{asset('/css/blogs.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section("content")
    <main id="blogs">
        <section class="new-pages-banner">
            <picture>
                <img src="{{asset('/assets/images/FerariF8TributoRedK2930InteriorFront.png')}}" alt="{{app('settings')->get('blog_title') ?? __('lang.Blogs')}}">
            </picture>
            <h2>{{app('settings')->get('blog_title') ?? __('lang.Blogs')}}</h2>
        </section>

        @include('website::cars.parts.breadcrumb', [
            'breadcrumbs' => [
                  app('settings')->get('blog_title') => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.blogs.index'))
            ]
        ])


        @include('website::layouts.parts.suggested-cars', ['suggested_cars' => $suggested_cars])

        <section class="blog-section my-5">
            <div class="container">
                <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-lg-6 mb-4">
                            <div class="blog-card">
                                <div class="blog-card-content">
                                    <picture>
                                        <img src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($blog->image)}}" alt=""
                                             class="mw-100 w-100">
                                    </picture>
                                    <h3>{{$blog->title}}</h3>
                                    <p>{{ Str::limit(strip_tags($blog->content), 150) }} .....</p>
                                </div>
                                <div class="blog-card-button">
                                    <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.blogs.show', ['blog' => $blog]))}}" class="secodary-button">
                                        {{__('lang.Read More')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        {{$blogs->links()}}
    </main>
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
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 991.89,
                        settings: {
                            slidesToShow: 1,
                            arrows: false,
                            dots: true,
                            centerMode: true,
                            centerPadding: '60px',
                        },
                    },
                    {
                        breakpoint: 767.89,
                        settings: {
                            slidesToShow: 1,
                            arrows: false,
                            dots: true,
                            centerMode: true,
                            centerPadding: '40px',
                        }
                    },
                    {
                        breakpoint: 424.89,
                        settings: {
                            slidesToShow: 1,
                            arrows: false,
                            dots: true,
                            centerMode: true,
                            centerPadding: '20px',
                        }
                    }
                ]
            });
        });

    </script>
@endsection