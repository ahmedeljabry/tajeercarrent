@extends('website::layouts.master')
@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => \App\Models\SEO::where('type', 'contact-us')->first(),
        "title" => __('lang.Contact Us'),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection
@section('css')
    <link href="{{asset('/css/contact-us.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section("content")
    <main id="contact-us">
        @include('website::layouts.parts.page-banner', [
    "title" => __('lang.Contact Us')
])

        @include('website::cars.parts.breadcrumb', [
          'breadcrumbs' => [
              __('lang.Contact Us') =>  null
          ]
        ])

        <section>
            @if (app('settings')->get('page_contact_us_title'))
                <div class="container">
                    <h1>{{app('settings')->get('page_contact_us_title')}}</h1>
                    <p>{!! app('settings')->get('page_contact_us_description') !!}</p>
                </div>
            @endif
            <div class="container map-container">
                <div class="map-box">
                    <i class="fa-solid fa-location-dot"></i>
                    <h2>{{__('lang.Head Office')}}</h2>
                    <h5>{{app('settings')->get('footer_address')}}</h5>
                </div>
                <div class="map-box">
                    <i class="fa-solid fa-phone"></i>
                    <h2>{{__('lang.Phone')}}</h2>
                    <h5><a href="tel:{{str_replace(' ', '', app('settings')->get('contact_phone'))}}">{{ app('settings')->get('contact_phone') }}</a></h5>
                    <h5>{{__('lang.Sales')}}:{{app('settings')->get('contact_phone')}}</h5>
                </div>
                <div class="map-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24">
                        <g>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path fill-rule="nonzero"
                                  d="M2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308a.961.961 0 0 0-.371.1 1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.729 2.729 0 0 0 6.9 9.62c.002.49.13.967.33 1.413.409.902 1.082 1.857 1.971 2.742.214.213.423.427.648.626a9.448 9.448 0 0 0 3.84 2.046l.569.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231c.166-.088.244-.132.383-.22 0 0 .043-.028.125-.09.135-.1.218-.171.33-.288.083-.086.155-.187.21-.302.078-.163.156-.474.188-.733.024-.198.017-.306.014-.373-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.401-.621a.498.498 0 0 0-.177-.041.482.482 0 0 0-.378.127v-.002c-.005 0-.072.057-.795.933a.35.35 0 0 1-.368.13 1.416 1.416 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.109l-.005-.002a6.01 6.01 0 0 1-1.57-1c-.126-.11-.243-.23-.363-.346a6.296 6.296 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41a4.38 4.38 0 0 0 .263-.373c.118-.19.155-.385.093-.536-.28-.684-.57-1.365-.868-2.041-.059-.134-.234-.23-.393-.249-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z">
                            </path>
                        </g>
                    </svg>
                    <h2>{{__("lang.Whatsapp")}}</h2>
                    <h5>
                        <a href="https://wa.me/{{str_replace(['+', ' '], '', app('settings')->get('contact_whatsapp'))}}" rel="nofollow noopener">
                            {{app('settings')->get('contact_whatsapp')}}
                        </a>
                    </h5>
                </div>
                <div class="map-box">
                    <i class="fa-solid fa-envelope"></i>
                    <h2>{{__("lang.Email")}}</h2>
                    <h5>
                        <a href="mailto:{{app('settings')->get('contact_whatsapp')}}">
                            {{app('settings')->get('contact_whatsapp')}}
                        </a>
                    </h5>
                </div>
            </div>
        </section>
    </main>



    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact_map">
                    {!!app('settings')->get('map')!!}
                    </div>
                </div>
                <div class="col-lg-6">
                    @if(session('success'))
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-success">
                                    {{__(session('success'))}}
                                </div>
                            </div>
                        </div>
                    @endif
                    <form action="{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.pages.contact-us'))}}" method="post">
                        @csrf
                        <div class="contact__form">
                            <h3>{{__('lang.Send us message')}}</h3>
                            <div class="form-group">
                                <label>{{__('lang.Name')}}</label>
                                <input type="text" name="name" required class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>{{__('lang.Email')}}</label>
                                <input type="email" name="email" required class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>{{__('lang.Phone')}}</label>
                                <input type="text" name="phone" required class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>{{__('lang.Message')}}</label>
                                <textarea class="form-control" name="message" required></textarea>
                            </div>
                            <div class="form-group">
                                <button>{{__('lang.Send Message')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
