@extends('website::layouts.master')

@section('css')
    <link href="{{asset('/css/car-list.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asseT('/css/my-account.css')}}" rel="stylesheet" type="text/css" />
@endsection

@php
    $cars = (clone $query)
        ->when(request('min_price'), function ($query, $min_price) {
            $query->where('price_per_day', '>=' , app('currencies')->getAedAmount($min_price));
        })
        ->when(request('max_price'), function ($query, $max_price) {
            $query->where('price_per_day', '<=' , app('currencies')->getAedAmount($max_price));
        })->paginate(10);
    $max_price = app('currencies')->convert((clone $query)->max('price_per_day'))
@endphp

@section('seo')
    @include('website::layouts.parts.seo', [
        'seo' => \App\Models\SEO::where('type','home')->first(),
        "title" => __('lang.Rent') . ' ' . request()->get('search'),
        "image" => secure_url('/') . '/storage/'. app('settings')->get('header_logo')
    ])
@endsection

@section("content")
    <main id="car-list">
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
    </main>


@endsection