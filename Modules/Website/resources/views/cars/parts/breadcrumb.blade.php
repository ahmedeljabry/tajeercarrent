    <div class="container mt-3">
        <div class="col-lg-12">
            <ul class="breadcrumb-list">
                <li>
                    <a href="{{LaravelLocalization::getLocalizedUrl(null, route('home'))}}">{{__('lang.Home')}}</a>
                </li>
                @foreach($breadcrumbs ?? [] as $title => $url)
                    <li>
                        @if(app()->getLocale() == 'ar')
                            <i class="fa fa-angle-left"></i>
                        @else
                            <i class="fa fa-angle-right"></i>
                        @endif
                    </li>
                    <li>
                        @if ($url)
                            <a class="link @if($loop->last) active @endif" href="{{$url}}">
                                <span> {{$title}}</span>
                            </a>
                        @else
                            <span class="@if ($loop->last) active @endif">{{$title}}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @section('schemas')
        <script type="application/ld+json">
            @php
                $data = [
                    "@context" => "https://schema.org",
                    "@type" => "BreadcrumbList",
                    "itemListElement" => [
                        [
                            "@type" => "ListItem",
                            "position" => 1,
                            "item" => [
                                "@id" => LaravelLocalization::getLocalizedURL(null, route('home')),
                                "name" => __('lang.Home')
                            ]
                        ]
                    ]
                ];
                $counter = 1;
                foreach($breadcrumbs ?? [] as $title => $url){
                    $data['itemListElement'][] = [
                        "@type" => "ListItem",
                            "position" => ++$counter,
                            "item" => [
                                "@id" => $url,
                                "name" => $title
                            ]
                    ];
                }
            @endphp
            @json($data)
        </script>
    @endsection
