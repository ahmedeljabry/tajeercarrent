<?php

namespace Modules\Website\App\Http\Controllers;

use App\Helpers\HasSuggestedCars;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Models;
use App\Models\Type;

class TypesController extends Controller
{
    use HasSuggestedCars;

    public function index(){
        $breadcrumbs = [
            __('lang.Car Types') => route('website.cars.types.index')
        ];
        return view('website::types.index')->with([
            'cars'         => null,
            'resource'     => null,
            'resource_type' => 'brand',
            'resource_sub_type' => 'models',
            'resource_title' => null,
            'resource_model' => null,
            'models'       => null,
            'selected_types' => null,
            'suggested_cars' => null,
            'seo'          => null,
            'content'      => null,
            'faq'          => null,
            'canonical'   =>  '/types',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function show($country, $city, Type $type){
        if ($type->slug == "yacht")
            return redirect()->route('website.yachts.index');

        if ($type->slug == "with-driver")
            return redirect()->route('website.cars.with-drivers');


        $query = $type->cars()->hasCompany()->orderBy('refreshed_at', 'desc')->where('type', 'default');

        if ($type->slug == "monthly")
            $query = Car::hasCompany()
                ->orderBy('refreshed_at', 'desc')
                ->where('type', 'default')
                ->where('price_per_month', '>', 0);

        $resource = $type;
        $selected_types = [$resource->slug];
        $seo      = \App\Models\SEO::where('type','type')->where('resource_id',$resource->id)->first();
        $content  = \App\Models\Content::where('type','type')->where('resource_id', $resource->id)->first();
        $faq      = \App\Models\Faq::where('type','type')->where('resource_id', $resource->id)->get();
        $resource_title  = __('lang.Categories');
        $models = [];

        $breadcrumbs = [
            __('lang.Car Types') => route('website.cars.types.index'),
            $type->title => null
        ];

        $suggested_cars = $this->getSuggestedCars(__('lang.Categories'), $resource->id);
        return view('website::cars.index')->with([
            'query'         => $query,
            'resource'     => $resource,
            'resource_type' => 'type',
            'resource_title' => $resource_title,
            'resource_model' => null,
            'models'       => $models,
            'selected_types' => $selected_types,
            'suggested_cars' => $suggested_cars,
            'seo'          => $seo,
            'content'      => $content,
            'faq'          => $faq,
            'canonical'   =>  $type->slug,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function model($country, $city, Type $type, Models $model){
        $query = $type->cars()->where(function ($query) use ($model){
            $query->where('model_id',$model->id);
            $query->where('type', 'default');
            $query->orderBy('refreshed_at', 'desc');
        });
        $resource = $type;
        $selected_types = [$resource->slug];
        $seo      = \App\Models\SEO::where('type','brand')->where('resource_id',$resource->id)->first();
        $content  = \App\Models\Content::where('type','brand')->where('resource_id', $resource->id)->first();
        $faq      = \App\Models\Faq::where('type','brand')->where('resource_id', $resource->id)->get();
        $resource_title  = __('lang.Car Brands');
        $models   = $resource->models()->limit(10)->get();
        $breadcrumbs = [
            __('lang.Car Types') => route('website.cars.types.index'),
            $type->title => route('website.cars.types.show', ['type' => $type]),
            $model->title => null,
        ];

        $suggested_cars = $this->getSuggestedCars(__('lang.Brands'), $resource->id);
        return view('website::cars.index')->with([
            'query'         => $query,
            'resource'     => $resource,
            'resource_type' => 'type',
            'resource_sub_type' => 'models',
            'resource_title' => $resource_title,
            'resource_model' => $model,
            'models'       => $models,
            'selected_types' => $selected_types,
            'suggested_cars' => $suggested_cars,
            'seo'          => $seo,
            'content'      => $content,
            'faq'          => $faq,
            'canonical'   =>  $type->slug,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
