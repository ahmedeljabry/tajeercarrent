<?php

namespace Modules\Website\App\Http\Controllers;

use App\Helpers\HasSuggestedCars;
use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use \App\Models\Car;
use \App\Models\Company;
use App\Models\Type;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CarsController extends Controller
{
    use HasSuggestedCars;
    public function show($country, $city, Car $car)
    {
        $suggested_cars = Car::with(['images','brand','model','color','types','company','year'])
            ->orderBy('refreshed_at', 'desc')
            ->where(function($query) use ($car) {
            if($car->brand_id) {
                $query->where('brand_id',$car->brand_id);
            }

            $query->where('type',$car->type);
            $query->where('id','!=',$car->id);
        })
        ->limit(10)->get();

        if($car->model) {
            $description = \App\Models\Content::where('type','model')->where('resource_id', $car->model->id)->first();
        } else {
            $description = null;
        }
        return view('website::cars.show')->with([
            'car' => $car,
            'suggested_cars' => $suggested_cars,
            'description' => $description
        ]);
    }

    public function filter($country, $city){
        $types = request('types');
        $monthly = in_array('monthly', $types);
        $types = array_filter($types, function ($value) {
            return $value != 'monthly';
        });

        $query = Car::with(['images','brand','model','color','types','company','year'])
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('cars.name->' . app()->getLocale(), 'like', '%' . $search . '%');
                });
            })
            ->when(request('order_by'), function ($query, $order) {
                $query->orderBy('price_per_day', $order == "price_low" ? "asc" : "desc");
            })
            ->when($monthly, function ($query, $types) {
                $query->where('price_per_month', '>', 0);
            })
            ->when($types, function ($query, $types) {
                $query->whereHas('types', function ($query) use ($types) {
                    $query->whereIn('slug', $types);
                });
            })
            ->when(request('brand'), function ($query, $brand) {
                $query->whereHas('brand', function ($query) use ($brand) {
                    $query->where('slug', $brand);
                });
            })
            ->when(request('model'), function ($query, $model) {
                $query->whereHas('model', function ($query) use ($model) {
                    $query->where('slug', $model);
                });
            })
            ->when(request('year'), function ($query, $year) {
                $query->whereHas('year', function ($query) use ($year) {
                    $query->where('title', $year);
                });
            })
            ->when(request('color'), function ($query, $color) {
                $query->whereHas('color', function ($query) use ($color) {
                    $query->where('slug', $color);
                });
            })
            ->orderBy('refreshed_at', 'desc')
            ->where('type', 'default');

        return view('website::cars.search')->with([
            'query'         => $query,
            'models'       => [],
            'selected_types' => request('types', []),
        ]);
    }

    public function with_driver(){
        $cars = Car::where('type', 'driver')
            ->orderBy('refreshed_at', 'desc')
            ->paginate(10);
        return view('website::cars.cars_with_driver', ['cars' => $cars]);
    }
}
