@php use Mcamara\LaravelLocalization\Facades\LaravelLocalization; @endphp
@php use App\Models\Type; @endphp
@php use App\Models\Faq; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    @section('seo')
    @show

    <link href="{{asset('/css/bootstrap/bootstrap.min.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('/js/slick-1.8.1/slick/slick.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/js/slick-1.8.1/slick/slick-theme.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/regular.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/solid.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/brands.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/fontawesome.css')}}" rel="stylesheet" type="text/css" />
    @section('css')
    @show

    <link href="{{asset('/css/home.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/styles.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/arabic-styles.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/navbar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css" />

    <link rel="icon" href="{{asset('/website/images/fav.jpg')}}" type="image/x-icon">
    <link href="{{url()->current()}}" rel="canonical"/>

    {!!app('settings')->get('scripts')!!}

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11558027423">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'AW-11558027423');
    </script>
</head>
<body class="@if(app()->getLocale()) arabic-version @endif">

{!!app('settings')->get('scripts_body')!!}



<div class="modal auth-modal login-modal fade" id="login-modal" tabindex="-1" aria-labelledby="{{__('lang.Sign in')}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center " id="exampleModalLabel">{{__('lang.Sign in')}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ LaravelLocalization::getLocalizedUrl(null, route('website.account.login')) }}" method="post">
                    @csrf
                    @if($errors->login->any())
                        <div class="alert alert-danger">
                            @foreach($errors->login->all() as $error)
                                {{$error}}
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-3">
                        <input name="email" type="email" class="form-control" placeholder="{{__('lang.Email')}}">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="{{__('lang.Password')}}">
                    </div>
                </form>
                <div class="auth-buttons d-flex flex-column ">
                    <button class="main-btn rounded-0 w-100 text-center" type="submit">{{__('lang.Sign in')}}</button>
                </div>
                <div class="auth-social-media-buttons d-flex align-items-center flex-column gap-2 mt-4">
                    <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.account.login_with_provider', ['provider' => 'facebook']))}}" class="facebook d-flex align-items-center justify-content-around w-100">
                        {{__('lang.Login with facebook')}}
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.account.login_with_provider', ['provider' => 'google']))}}" class="google-auth d-flex align-items-center justify-content-around w-100">
                        {{__('lang.Login with google')}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 326667 333333"
                             shape-rendering="geometricPrecision" text-rendering="geometricPrecision"
                             image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd">
                            <path
                                    d="M326667 170370c0-13704-1112-23704-3518-34074H166667v61851h91851c-1851 15371-11851 38519-34074 54074l-311 2071 49476 38329 3428 342c31481-29074 49630-71852 49630-122593m0 0z"
                                    fill="#4285f4" />
                            <path
                                    d="M166667 333333c44999 0 82776-14815 110370-40370l-52593-40742c-14074 9815-32963 16667-57777 16667-44074 0-81481-29073-94816-69258l-1954 166-51447 39815-673 1870c27407 54444 83704 91852 148890 91852z"
                                    fill="#34a853" />
                            <path
                                    d="M71851 199630c-3518-10370-5555-21482-5555-32963 0-11482 2036-22593 5370-32963l-93-2209-52091-40455-1704 811C6482 114444 1 139814 1 166666s6482 52221 17777 74814l54074-41851m0 0z"
                                    fill="#fbbc04" />
                            <path
                                    d="M166667 64444c31296 0 52406 13519 64444 24816l47037-45926C249260 16482 211666 1 166667 1 101481 1 45185 37408 17777 91852l53889 41853c13520-40185 50927-69260 95001-69260m0 0z"
                                    fill="#ea4335" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal auth-modal sign-up-modal fade" id="sign-up-modal" tabindex="-1" aria-labelledby="{{__('lang.Sign up')}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center " id="exampleModalLabel">{{__('lang.Sign up')}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{LaravelLocalization::getLocalizedUrl(null, route('website.account.register'))}}" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="{{__('lang.Name')}}">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="{{__('lang.Email')}}">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="{{__('lang.Password')}}">
                    </div>
                </form>
                <div class="auth-buttons d-flex flex-column ">
                    <a href="#" class="main-btn rounded-0 w-100 text-center ">{{__('lang.Sign up')}}</a>
                </div>
                <p class="tcp-content">
                    By Continuing you agree to our <a href="#">terms & conditions</a> and <a href="#">
                        privacy
                    </a>
                </p>
                <div class="auth-social-media-buttons d-flex align-items-center flex-column gap-2 mt-3">
                    <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.account.login_with_provider', ['provider' => 'facebook']))}}" class="facebook d-flex align-items-center justify-content-around w-100">
                        {{__('lang.Login with facebook')}}
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.account.login_with_provider', ['provider' => 'google']))}}" class="google-auth d-flex align-items-center justify-content-around w-100">
                        {{__('lang.Login with google')}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 326667 333333"
                             shape-rendering="geometricPrecision" text-rendering="geometricPrecision"
                             image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd">
                            <path
                                    d="M326667 170370c0-13704-1112-23704-3518-34074H166667v61851h91851c-1851 15371-11851 38519-34074 54074l-311 2071 49476 38329 3428 342c31481-29074 49630-71852 49630-122593m0 0z"
                                    fill="#4285f4" />
                            <path
                                    d="M166667 333333c44999 0 82776-14815 110370-40370l-52593-40742c-14074 9815-32963 16667-57777 16667-44074 0-81481-29073-94816-69258l-1954 166-51447 39815-673 1870c27407 54444 83704 91852 148890 91852z"
                                    fill="#34a853" />
                            <path
                                    d="M71851 199630c-3518-10370-5555-21482-5555-32963 0-11482 2036-22593 5370-32963l-93-2209-52091-40455-1704 811C6482 114444 1 139814 1 166666s6482 52221 17777 74814l54074-41851m0 0z"
                                    fill="#fbbc04" />
                            <path
                                    d="M166667 64444c31296 0 52406 13519 64444 24816l47037-45926C249260 16482 211666 1 166667 1 101481 1 45185 37408 17777 91852l53889 41853c13520-40185 50927-69260 95001-69260m0 0z"
                                    fill="#ea4335" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



{{--<div class="scroll-up">--}}
{{--    <img width="50" height="100" alt="scroll" src="{{asset('/website/images/scroll_up.png')}}"/>--}}
{{--</div>--}}


<header>
    <div class="px-4">
        <div class="row">
            <div class=" col-lg-6 col-xl-2 col-5">
                <a href="{{url(app()->getLocale())}}">
                    <div class="logo">
                        <img width="197" height="60" src="{{asset('/storage/' .  app("settings")->get("header_logo")) }}" alt="logo" class="mw-100">
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-xl-3 col-md-7 col-12 mt-4 mt-md-0 justify-content-end  ">
                <a href="{{LaravelLocalization::getLocalizedUrl(null, route('website.pages.list-your-car'))}}"
                   class="d-flex h-100 justify-content-lg-end justify-content-center  ">
                    <div class="header__list_your_car">
                        <img width="30" height="30" alt="listcar" class="car"
                             src="{{asset('/website/images/header_car.png')}}">
                        <p>{{__('lang.List your cars in TAJEER platform')}}</p>
                        <img alt="upload" class="icon" width="26" height="25"
                             src="{{asset('/website/images/icons/upload.png')}}">
                    </div>
                </a>
            </div>
            <div class="col-lg-7">
                <ul class="header__actions desktop__header_actions desktop-view-btns">
                    <li class="header__actions_list_item">
                        <p>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{__('lang.Location')}}</span>
                        </p>
                        <div class="dropdown ">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{app('country')->getCountry()->title}}
                            </a>

                            <ul class="dropdown-menu">
                                @foreach(app('country')->getAllCountries() as $country)
                                    @if(count($country->cities) > 0)
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <a href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.switch.country', ['country' => $country])) }}" class="title-dropdown">{{$country->title}}</a>

                                                    <ul>
                                                        @foreach($country->cities as $city)
                                                            <li class="@if(app('country')->getCity() && $city->id == app('country')->getCity()->id) active @endif">
                                                                <a href="{{ LaravelLocalization::getLocalizedURL(null, route('website.switch.city', ['city' => $city])) }}">
                                                                    {{$city->title}}
                                                                </a>
                                                                @if (app('country')->getCity() && $city->id == app('country')->getCity()->id)
                                                                    <i class="fa-solid fa-check"></i>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="header__actions_list_item">
                        <p>
                            <i class="fa-solid fa-dollar-sign"></i>
                            <span>{{__('lang.Currency')}}</span>
                        </p>
                        <div class="dropdown ">
                            <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{app('currencies')->getCurrency()->code}}
                            </a>

                            <ul class="dropdown-menu">
                                @foreach(app('currencies')->getAllCurrencies() as $currency)
                                    <li>
                                        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL(null, route("website.switch.currency", ['currency' => $currency])) }}">{{$currency->code}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="header__actions_list_item">
                        <p>
                            <i class="fa fa-language"></i>
                            <picture>
                                <img src="{{asset('assets/icons/lang_' . app()->getLocale() . '.png')}}" alt="" class="mw-100">
                            </picture>
                            <span>{{ __('lang.Language') }}</span>
                        </p>
                        <div class="dropdown ">
                            <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{config('app.languages')[app()->getLocale()]}}
                            </a>

                            <ul class="dropdown-menu">
                                @foreach (LaravelLocalization::getSupportedLocales() as $langCode => $langDetails)
                                    <li>
                                        <a href="{{ LaravelLocalization::getLocalizedURL($langCode, null, [], true)  }}" class="dropdown-item">
                                            <picture>
                                                <img src="{{asset('assets/icons/lang_' . $langCode . '.png')}}" alt="" class="mw-100">
                                            </picture>
                                            {{$langDetails['name']}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="header__actions_list_item">
                        <div class="auth-btns text-white  d-flex align-items-center gap-2">
                            <a class="text-white text-decoration-underline " data-bs-toggle="modal"
                               data-bs-target="#login-modal">
                                {{__('lang.Sign in')}}
                            </a>
                            {{__('lang.Or')}}
                            <a class="text-white text-decoration-underline " data-bs-toggle="modal"
                               data-bs-target="#sign-up-modal">
                                {{__('lang.Sign up')}}
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</header>

<nav class="navbar navbar-expand-lg bg-white p-0 sticky-top">
    <div class="navbar-container d-flex justify-content-between align-items-center px-4 w-100">
        <div class="desktop-view d-flex align-items-center justify-content-between w-100 ">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="{{url(app()->getLocale())}}">{{__('lang.Home')}}</a>
                </li>
                <li class="nav-item ">
                    <div class="dropdown">
                        <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{__('lang.Car Brands')}}
                        </a>
                        <ul class="dropdown-menu brands-logo">
                            <ul class="row">
                                @foreach(app('cars')->brands as $item)
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.cars.brands.show', ['brand' => $item]))}}">
                                            <picture>
                                                <img src="/storage/{{\App\Helpers\WebpImage::generateUrl($item->image)}}" alt="" class="mw-100">
                                            </picture>
                                            {{$item->title}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </ul>
                    </div>
                </li>

                @if ($type = Type::whereSlug('with-driver')->first())
                    <li class="nav-item active">
                        <a class="nav-link"
                           href="{{ LaravelLocalization::getLocalizedURL(null, route('website.cars.with-drivers')) }}">{{__('lang.Rent a car with driver')}}</a>
                    </li>
                @endif

                @if ($type = Type::whereSlug('yachts')->first())
                    <li class="nav-item active">
                        <a class="nav-link"
                           href="{{ LaravelLocalization::getLocalizedURL(null, route('website.yachts.index')) }}">{{__('lang.Rent yacht')}}</a>
                    </li>
                @endif

                <li class="nav-item active">
                    <a class="nav-link" href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.blogs.index')) }}">{{__('lang.Blog')}}</a>
                </li>

                <li class="nav-item ">
                    <div class="dropdown ">
                        <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{__('lang.Quick Links')}}
                        </a>
                        <ul class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ LaravelLocalization::getLocalizedURL(null, route('website.pages.contact-us')) }}">{{__('lang.Contact Us')}}</a>
                            @foreach(app('settings')->getHeaderPages() as $item)
                                <a class="dropdown-item"
                                   href="{{ LaravelLocalization::getLocalizedURL(null, route('website.pages.show', ['page' => $item])) }}">{{$item->name}}</a>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="nav-icons my-2 my-lg-0 flex-column mt-5 mt-lg-0   ">
                <ul class="mb-4 mb-lg-0 ">
                    <li>
                        <a href="tel:{{str_replace(' ', '', app('settings')->get('contact_phone'))}}">
                            <img width="36" height="36" alt="call"
                                 src="{{asset('/website/images/icons/call.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="{{app('settings')->get('contact_facebook')}}">
                            <img width="36" height="36" alt="fb"
                                 src="{{asset('/website/images/icons/facebook.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="{{app('settings')->get('contact_twitter')}}">
                            <img width="36" height="36" alt="twitter"
                                 src="{{asset('/website/images/icons/twitter.png')}}">
                        </a>
                    </li>
                    <li>
                        <a href="{{app('settings')->get('contact_instagram')}}">
                            <img width="36" height="36" alt="instagrm"
                                 src="{{asset('/website/images/icons/instagram.png')}}">
                        </a>
                    </li>
                </ul>
                <ul class="apps">
                    <li>
                        <a href="{{app('settings')->get('app_google_play')}}">
                            <img width="125" height="37" alt="app" class="apps-image"
                                 src="{{asset('/website/images/icons/googleplay.webp')}}">
                        </a>
                    </li>
                    <li>
                        <a href="{{app('settings')->get('app_apple_store')}}">
                            <img alt="app" width="115" height="41" class="apps-image"
                                 src="{{asset('/website/images/icons/appstore.webp')}}">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <button class="navbar-toggler bar-icon" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="header__actions desktop__header_actions mobile-view-btns">
            <li class="header__actions_list_item">
                <p>
                    <i class="fa-solid fa-location-dot"></i>
                </p>
                <div class="dropdown ">
                    <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{app('country')->getCountry()->title}}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(app('country')->getAllCountries() as $country)
                            @if(count($country->cities) > 0)
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <a href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.switch.country', ['country' => $country])) }}" class="title-dropdown">{{app('country')->getCountry()->title}}</a>
                                            <ul>
                                                @foreach($country->cities as $city)
                                                    <li class="@if(app('country')->getCity() && $city->id == app('country')->getCity()->id) active @endif">
                                                        <a href="{{ LaravelLocalization::getLocalizedURL(null, route('website.switch.city', ['city' => $city])) }}">
                                                            {{$city->title}}
                                                        </a>
                                                        @if (app('country')->getCity() && $city->id == app('country')->getCity()->id)
                                                            <i class="fa-solid fa-check"></i>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="header__actions_list_item">
                <p>
                    <i class="fa-solid fa-dollar-sign"></i>
                </p>
                <div class="dropdown ">
                    <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        {{app('currencies')->getCurrency()->code}}
                    </a>
                    <ul class="dropdown-menu">
                        @foreach(app('currencies')->getAllCurrencies() as $currency)
                            <li>
                                <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL(null, route("website.switch.currency", ['currency' => $currency])) }}">{{$currency->code}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="header__actions_list_item">
                <p>
                    <i class="fa fa-language"></i>
                    <picture>
                        <img src="{{asset('/assets/icons/lang_' . app()->getLocale(). '.png')}}" alt="" class="mw-100">
                    </picture>
                    <span>{{ __('lang.Language') }}</span>
                </p>
                <div class="dropdown ">
                    <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Arabic
                    </a>

                    <ul class="dropdown-menu">
                        @foreach (LaravelLocalization::getSupportedLocales() as $langCode => $langDetails)
                            <li>
                                <a href="{{ LaravelLocalization::getLocalizedURL($langCode, null, [], true)  }}" class="dropdown-item">
                                    <picture>
                                        <img src="{{asset('/assets/icons/lang_' . $langCode. '.png')}}" alt="" class="mw-100">
                                    </picture>
                                    {{$langDetails['name']}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="header__actions_list_item">
                <p>
                    <i class="fa fa-language"></i>
                </p>
                <div class="dropdown ">
                    <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        {{config('app.languages')[app()->getLocale()]}}
                    </a>

                    <ul class="dropdown-menu">
                        @foreach (LaravelLocalization::getSupportedLocales() as $langCode => $langDetails)
                            <li>
                                <a href="{{ LaravelLocalization::getLocalizedURL($langCode, null, [], true)  }}" class="dropdown-item">
                                    <picture>
                                        <img src="./assets/icons/lang_{{$langCode}}.png" alt="" class="mw-100">
                                    </picture>
                                    {{$langDetails['name']}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
        <div class="offcanvas offcanvas-end mobile-view" tabindex="-1" id="offcanvasNavbar"
             aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <img width="197" height="60" src="./assets/images/logo.png" alt="logo">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="offcanvas-body d-flex align-items-center">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="https://tajeercarrent.com/en/uae/bur-dubai">Home</a>
                    </li>
                    <li class="nav-item ">
                        <div class="dropdown">
                            <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Car brands
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu brands-logo">
                                <ul class="row">
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/mercedes.webp" alt="" class="mw-100">
                                            </picture>
                                            Mercedes
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/lamb.webp" alt="" class="mw-100">
                                            </picture>
                                            Lamborghini
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/Rang-rover.webp" alt=""
                                                     class="mw-100">
                                            </picture>
                                            Rang Rover
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/nissan.webp" alt="" class="mw-100">
                                            </picture>
                                            Nissan
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/mercedes.webp" alt="" class="mw-100">
                                            </picture>
                                            Mercedes
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/lamb.webp" alt="" class="mw-100">
                                            </picture>
                                            Lamborghini
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/Rang-rover.webp" alt=""
                                                     class="mw-100">
                                            </picture>
                                            Rang Rover
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/nissan.webp" alt="" class="mw-100">
                                            </picture>
                                            Nissan
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/mercedes.webp" alt="" class="mw-100">
                                            </picture>
                                            Mercedes
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/lamb.webp" alt="" class="mw-100">
                                            </picture>
                                            Lamborghini
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/Rang-rover.webp" alt=""
                                                     class="mw-100">
                                            </picture>
                                            Rang Rover
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/nissan.webp" alt="" class="mw-100">
                                            </picture>
                                            Nissan
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/mercedes.webp" alt="" class="mw-100">
                                            </picture>
                                            Mercedes
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/lamb.webp" alt="" class="mw-100">
                                            </picture>
                                            Lamborghini
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/Rang-rover.webp" alt=""
                                                     class="mw-100">
                                            </picture>
                                            Rang Rover
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/nissan.webp" alt="" class="mw-100">
                                            </picture>
                                            Nissan
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/mercedes.webp" alt="" class="mw-100">
                                            </picture>
                                            Mercedes
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/lamb.webp" alt="" class="mw-100">
                                            </picture>
                                            Lamborghini
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/Rang-rover.webp" alt=""
                                                     class="mw-100">
                                            </picture>
                                            Rang Rover
                                        </a>
                                    </li>
                                    <li class="col-lg-3">
                                        <a class="dropdown-item" href="#">
                                            <picture>
                                                <img src="./assets/images/nissan.webp" alt="" class="mw-100">
                                            </picture>
                                            Nissan
                                        </a>
                                    </li>
                                </ul>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./rent.html">Rent
                            a
                            car with
                            driver
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./car-rental.html">Rent
                            yacht</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./blogs.html">Blog</a>
                    </li>
                    <li class="nav-item ">
                        <div class="dropdown ">
                            <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Quick Links
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="./contact-us.html">
                                        Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./about-us.html">
                                        About Us
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./web-privacy-terms-and-condition.html">
                                        Our Service
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./web-privacy-terms-and-condition.html">
                                        Terms & Conditions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <div class="account-info d-flex flex-column gap-3 w-100 ">
                    <a href="#" class="my-account d-flex align-items-center gap-2">
                        <i class="fa-regular fa-circle-user"></i>
                        <p class="mb-0">My Account</p>
                    </a>
                    <div class="auth-btns d-flex align-items-center justify-content-around "
                         data-bs-toggle="modal" data-bs-target="#login-modal">
                        <a href=" #" class="main-btn">
                            Login
                        </a>
                        <a href="#" class="main-btn" data-bs-toggle="modal" data-bs-target="#sign-up-modal">
                            Sign Up
                        </a>
                    </div>
                </div>
                <div class=" nav-icons my-2 my-lg-0 flex-column mt-lg-0 d-flex w-100 justify-content-center
                                    align-items-center ">
                    <ul class=" mb-4 mb-xlg-0 ">
                        <li>
                            <a href=" tel:+971 56 442 4448">
                                <img width="36" height="36" alt="call"
                                     src="https://tajeercarrent.com/website/images/icons/call.png">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/Tajeercarrental">
                                <img width="36" height="36" alt="fb"
                                     src="https://tajeercarrent.com/website/images/icons/facebook.png">
                            </a>
                        </li>
                        <li>
                            <a href="https://x.com/tajeercarrental">
                                <img width="36" height="36" alt="twitter"
                                     src="https://tajeercarrent.com/website/images/icons/twitter.png">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/tajeercarrental/">
                                <img width="36" height="36" alt="instagrm"
                                     src="https://tajeercarrent.com/website/images/icons/instagram.png">
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a
                                    href="https://play.google.com/store/apps/details?id=com.tajeer&amp;hl=en&amp;gl=US&amp;pli=1">
                                <img width="125" height="37" alt="app" class="apps-image"
                                     src="https://tajeercarrent.com/website/images/icons/googleplay.webp">
                            </a>
                        </li>
                        <li>
                            <a href="https://apps.apple.com/ae/app/tajeer-rent-a-car-in-dubai/id1458290275">
                                <img alt="app" width="115" height="41" class="apps-image"
                                     src="https://tajeercarrent.com/website/images/icons/appstore.webp">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

@section("content")
@show

<section>
    <div class="container">
        <div class="social-icons-new-box">
            <a href="tel:{{str_replace(' ', '', app('settings')->get('contact_phone'))}}">
                <picture>
                    <img src="{{asset('/assets/images/Group 2704.png')}}" alt="اتصال">
                </picture>
            </a>
            <a href="{{app('settings')->get('contact_facebook')}}">
                <picture>
                    <img src="{{asset('/assets/images/Path 1072.png')}}" alt="فيسبوك">
                </picture>
            </a>
            <a href="{{app('settings')->get('contact_twitter')}}">
                <picture>
                    <img src="{{asset('/assets/images/Group 2707.png')}}" alt="تويتر">
                </picture>
            </a>
            <a href="{{app('settings')->get('contact_instagram')}}">
                <picture>
                    <img src="{{asset('/assets/images/XMLID_13_.png')}}" alt="انستجرام">
                </picture>
            </a>

        </div>
    </div>
</section>

<footer>
    <img class="bg" loading="lazy" src="{{asset('/website/images/footer_bg.webp')}}" alt="bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 links-footer">
                <ul>
                    <li>
                        <a data-toggle="tooltip" data-placement="left" title="{{__('lang.FAQ')}}"
                           href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.pages.faq')) }}">{{__('lang.FAQ')}}</a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" data-placement="left" title="{{__('lang.Blog')}}"
                           href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.blogs.index')) }}">{{__('lang.Blog')}}</a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" data-placement="left" title="{{__('lang.Contact Us')}}"
                           href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.pages.contact-us')) }}">{{__('lang.Contact Us')}}</a>
                    </li>
                </ul>
                <ul>
                    @foreach(app('settings')->getFooterPages() as $key => $item)
                        <li>
                            <a data-toggle="tooltip" data-placement="left" title="{{$item->name}}"
                               href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.pages.show', ['page' => $item])) }}">{{$item->name}}</a>
                        </li>
                    @endforeach
                </ul>
                <ul>
                    @foreach(Type::get() as $t)
                        <li>
                            <a data-toggle="tooltip" data-placement="left" title="{{__('lang.Rent')}} {{$t->title}}"
                               href="{{ LaravelLocalization::getLocalizedURL(null, route('website.cars.types.show', ['type' => $t])) }}">{{__('lang.Rent')}} {{$t->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3">
                <div class="footer-apps">
                    <p>
                        <span class="text-white ">{{__('lang.Downloads')}}</span>
                        <a style="margin-top:15px;display:block"
                           href="{{app('settings')->get('app_google_play')}}">
                            <img alt="app" width="125" height="37"
                                 src="{{asset('/website/images/icons/googleplay.webp')}}">
                        </a>
                        <a href="{{app('settings')->get('app_apple_store')}}">
                            <img loading="lazy" width="125" height="37" style="margin-top:10px" alt="app"
                                 src="{{asset('/website/images/icons/appstore2.webp')}}">

                        </a>
                    </p>
                    <ul class="contact-footer p-0 " style="margin-top:20px;display:block">
                        <li class="list-unstyled ">
                            <a href="tel:{{str_replace(' ', '', app('settings')->get('contact_phone'))}}">
                                <i class="fa-solid fa-phone"></i>
                                {{app('settings')->get('contact_phone')}}</a>

                        </li>
                        <li class="list-unstyled ">
                            <a href="https://wa.me/{{str_replace(['+', ' '], '', app('settings')->get('contact_whatasapp'))}}">
                                <i class="fa-brands fa-whatsapp whatsapp-contact"></i> {{app('settings')->get('contact_whatsapp')}}
                            </a>
                        </li>
                        <li class="list-unstyled ">
                            <a href="mailto:{{app('settings')->get('contact_email')}}">
                                <i class="fa-solid fa-envelope"></i>
                                {{app('settings')->get('contact_email')}}
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-bottom">
                    <p>
                        {{app('settings')->get('footer_address')}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript" src="{{asset('/js/jquery-3.7.1.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/slick-1.8.1/slick/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/intlTelInputWithUtils.min.js')}}"/>
<script src="{{asset('/js/main.js')}}"></script>
<script src="{{asset('js/wow.js')}}"></script>
<script>
    new WOW().init();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.read-more-btn').forEach(btn => {
            const descriptionText = btn.previousElementSibling;

            btn.addEventListener('click', function () {
                if (descriptionText.classList.contains('expanded')) {
                    descriptionText.classList.remove('expanded');
                    this.textContent = '{{__('lang.Read More')}}';
                } else {
                    descriptionText.classList.add('expanded');
                    this.textContent = '{{__('lang.Read Less')}}';
                }
            });
        });
    });
</script>

@section("js")
@show

@if($errors->signup->any())
    <script>
        $('#signupModal').modal('show');
    </script>
@endif
@if($errors->login->any() || request()->get('login'))
    <script>
        $('#signinModal').modal('show');
    </script>
@endif


@section('breadcrumbs')
@show

<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "LocalBusiness",
        "name": "TAJEER",
        "image": "{{asset('/')}}/storage/{{app('settings')->get('header_logo')}}",
            "telephone": "{{app('settings')->get('contact_phone')}}",
            "priceRange": "AED 100-60000",
            "email": "{{app('settings')->get('contact_email')}}",
            "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "{{app('settings')->get('footer_address')}}",
                    "addressLocality": "Dubai",
                    "postalCode": "00000",
                    "addressCountry": "AE"
             },
            "url": "{{secure_url('/')}}"
        }
</script>


<script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "ImageObject",
        "description":"{{app('settings')->get('title')}}",
                "image":"{{asset('/')}}/storage/{{app('settings')->get('header_logo')}}",
                "name":"{{app('settings')->get('title')}}",
                "potentialAction":"logo",
                "url":"{{secure_url('/')}}"
        }
</script>

@section('schemas')
@show
</body>
</html>
