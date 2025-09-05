@extends('website::layouts.master')
@section('seo')
    @include('website::layouts.parts.seo', [
        "seo" => \App\Models\SEO::where('type', 'blog')->where('resource_id', $blog->id)->first(),
        "title" => $blog->getTranslation("title", \App::getLocale()),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection
@section("content")

    @include('website::layouts.parts.page-banner', [
        "title" => $blog->getTranslation("title", \App::getLocale())
    ])

    <section class="home__about list__item">
        @include('website::cars.parts.breadcrumb', [
            'breadcrumbs' => [
                  app('settings')->get('blog_title') => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.blogs.index')),
                  $blog->title => null
            ]
        ])
        <div class="container">
            <div class="row mt-50">
                <div class="col-lg-12">

                    @if($blog)
                    <div class="home__about_content blog-item">
                        <h2>{{$blog->getTranslation("title", \App::getLocale())}}</h2>

                        @if($blog->image)
                        <img alt="{{$blog->getTranslation("title", \App::getLocale())}}" src="/storage/{{\App\Helpers\WebpImage::generateUrl($blog->image)}}" />
                        @endif
                        {!!$blog->content!!}
                    </div>
                    @endif


                </div>

            </div>
        </div>
    </section>

@endsection
