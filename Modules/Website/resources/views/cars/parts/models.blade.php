    @if(count($models) > 0)
        <section class="filter-buttons-section py-5">
            <div class="container">
                <div class="filter-buttons-container">
                    <ul class="d-flex flex-wrap">
                        @foreach ($models as $model)
                            @continue($model->cars()->count() == 0)
                            <li>
                                <a href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.cars.brands.models', ['brand' => $resource, 'model' => $model])) }}">
                                    {{__('lang.Rent')}} {{$model->title}} ({{$model->cars()->count()}})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif
