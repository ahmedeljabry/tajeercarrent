@extends('website::layouts.master')

@section('css')
    <link href="{{asset('/css/car-list.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asseT('/css/my-account.css')}}" rel="stylesheet" type="text/css" />
@endsection

@php
    $cars = (clone $query)
       ->orderBy('refreshed_at', 'desc')
       ->when(request('min_price'), function ($query, $min_price) {
           $query->where('price_per_day', '>=' , app('currencies')->getAedAmount($min_price));
       })
       ->when(request('max_price'), function ($query, $max_price) {
           $query->where('price_per_day', '<=' , app('currencies')->getAedAmount($max_price));
       })->paginate(10);
   $max_price = app('currencies')->convert((clone $query)->max('price_per_day'))
@endphp

@section('seo')
    <link href="{{url()->current()}}" rel="canonical" />
    @include('website::layouts.parts.seo', [
        'seo' => $seo,
        "title" => $resource ? $resource->title : "",
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection

@section("content")
    <main id="car-list">
        @if (isset($breadcrumbs))
            @include('website::cars.parts.breadcrumb', [
                'breadcrumbs' => $breadcrumbs
            ])
        @else
            @include('website::cars.parts.breadcrumb', [
                'breadcrumbs' => [
                    __("lang.Car Brands") => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.index')),
                    $resource->title => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(null, route('website.cars.brands.show', ['brand' => $resource]))
                ]
            ])
        @endif
        <div class="section-header container">
            <div class="section-header-title">
                <h1 class="fw-normal ">{{__('lang.Rent') . " " . ($resource_model?->title ?? $resource->title) . " " . __("lang.In") . " " . optional(app('country')->getCity())->title}}</h1>
            </div>
            @if ($description = $resource_model?->page_description ?? $resource?->page_description ?? "")
                <div class="description-container">
                    <p class="description-text">
                        {!! $description !!}
                    </p>
                </div>
            @endif
        </div>

        @include('website::cars.parts.models')

        <div class="container">
            <form action="{{route('website.cars.filter')}}" method="get">
                <div class="row mt-50">

                    <div class="col-lg-3">
                        @include('website::cars.parts.filters')
                    </div>

                    <div class="col-lg-9">

                        <div class="products-page__sort_by_holder">
                            <div class="products-page__sort_by">
                                <span>{{__('lang.Sort By')}} </span>
                                <select class="form-control order-by" name="order_by">
                                    <option @if(!request()->get('order_by')) selected @endif value="">{{__('lang.Latest')}}</option>
                                    <option @if(request()->get('order_by') == "price_low") selected @endif value="price_low">{{__('lang.Price Low')}}</option>
                                    <option @if(request()->get('order_by') == "price_high") selected @endif value="price_high">{{__('lang.Price High')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="rental-details-container">
                            <div class="account-settings-card-wrapper">
                                @foreach($cars as $car)
                                    @include('website::cars.parts.car', ['car' => $car])
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="col-12">
                {{$cars->appends(request()->input())->links()}}
            </div>
        </div>

        @include('website::layouts.parts.suggested-cars', ['suggested_cars' => $suggested_cars])

        @include('website::layouts.parts.content', [
            "content" => $content
        ])

        @include('website::layouts.parts.faq', [
            "faq" => $faq
        ])
    </main>


@endsection
