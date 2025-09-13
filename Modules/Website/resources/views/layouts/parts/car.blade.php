<div class="rent-car-slide">
    <a href="{{ LaravelLocalization::getLocalizedUrl(null, route('website.cars.show', ['car' => $car])) }}">
        <div class="car-rent-title">
            <picture>
                <img src="{{asset("/storage/") . "/" . \App\Helpers\WebpImage::generateUrl($car->image)}}" alt="">
                <div class="rent-car-labels">
                    @if ($car->is_refresh)
                        <div class="rent-car-label Featured">
                            <span>{{__('lang.Featured')}}</span>
                        </div>
                    @endif
                    <div class="rent-car-label Premium">
                        <span>{{__('lang.Premium')}}</span>
                    </div>
                    <div class="rent-car-label Verified">
                        <span>{{__('lang.Verified')}}</span>
                    </div>
                </div>
            </picture>
            <div class="rent-car-slide-tittle">
                <h4>{{$car->name}}</h4>
            </div>
        </div>
        <div class="rent-car-slide-description">
            <ul>
                @if ($car->security_deposit)
                    <li>{{__('lang.Deposit')}} / {{app('currencies')->convert($car->security_deposit)}} {{app('currencies')->getCurrency()->code}}</li>
                @endif
                @if($car->minimum_day_booking)
                    <li>
                        {{__('lang.Minimum of Days')}} / {{$car->minimum_day_booking}}
                    </li>
                @endif
                <li>{{__('lang.Insurance Type')}} / {{__('lang.Full')}} </li>
                @if ($car->km_per_day)
                    <li>
                        {{__('lang.KM Limit Day')}} / {{$car->km_per_day}}
                    </li>
                @endif
            </ul>
            <div class="rent-car-slide-description-blue-boxes">
                @if ($car->price_per_day)
                    <div class="rent-car-slide-description-blue-box">
                        <span>{{__('lang.Day')}} / {{app('currencies')->convert($car->price_per_day)}} {{app('currencies')->getCurrency()->code}}</span>
                    </div>
                @endif
                @if($car->price_per_week)
                    <div class="rent-car-slide-description-blue-box">
                        <span>{{__('lang.Day')}}/{{app('currencies')->convert($car->price_per_week)}} {{app('currencies')->getCurrency()->code}}</span>
                    </div>
                @endif
                @if($car->price_per_month)
                    <div class="rent-car-slide-description-blue-box">
                        <span>{{__('lang.Month')}} / {{app('currencies')->convert($car->price_per_month)}} {{app('currencies')->getCurrency()->code}}</span>
                    </div>
                @endif

            </div>
        </div>
    </a>
    <div class="rent-car-slide-footer">
        <a href="https://wa.me/{{str_replace(['+', ' '], '', app('settings')->get('contact_phone'))}}?text={{urlencode("Hello I Am Interested On This Car, " . LaravelLocalization::getLocalizedUrl(null, route('website.cars.show', ['car' => $car])))}}" target="_blank" rel="noopener">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px"
                     viewBox="0 0 24 24">
                    <g>
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill-rule="nonzero"
                              d="M2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308a.961.961 0 0 0-.371.1 1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.729 2.729 0 0 0 6.9 9.62c.002.49.13.967.33 1.413.409.902 1.082 1.857 1.971 2.742.214.213.423.427.648.626a9.448 9.448 0 0 0 3.84 2.046l.569.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231c.166-.088.244-.132.383-.22 0 0 .043-.028.125-.09.135-.1.218-.171.33-.288.083-.086.155-.187.21-.302.078-.163.156-.474.188-.733.024-.198.017-.306.014-.373-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.401-.621a.498.498 0 0 0-.177-.041.482.482 0 0 0-.378.127v-.002c-.005 0-.072.057-.795.933a.35.35 0 0 1-.368.13 1.416 1.416 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.109l-.005-.002a6.01 6.01 0 0 1-1.57-1c-.126-.11-.243-.23-.363-.346a6.296 6.296 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41a4.38 4.38 0 0 0 .263-.373c.118-.19.155-.385.093-.536-.28-.684-.57-1.365-.868-2.041-.059-.134-.234-.23-.393-.249-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z">
                        </path>
                    </g>
                </svg>
            </div>
            <span>{{__('lang.Whatsapp')}}</span>
        </a>
        <a href="mailto:{{app('settings')->get('contact_email')}}">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px"
                     viewBox="0 0 24 24">
                    <g>
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill-rule="nonzero"
                              d="M2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308a.961.961 0 0 0-.371.1 1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.729 2.729 0 0 0 6.9 9.62c.002.49.13.967.33 1.413.409.902 1.082 1.857 1.971 2.742.214.213.423.427.648.626a9.448 9.448 0 0 0 3.84 2.046l.569.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231c.166-.088.244-.132.383-.22 0 0 .043-.028.125-.09.135-.1.218-.171.33-.288.083-.086.155-.187.21-.302.078-.163.156-.474.188-.733.024-.198.017-.306.014-.373-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.401-.621a.498.498 0 0 0-.177-.041.482.482 0 0 0-.378.127v-.002c-.005 0-.072.057-.795.933a.35.35 0 0 1-.368.13 1.416 1.416 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.109l-.005-.002a6.01 6.01 0 0 1-1.57-1c-.126-.11-.243-.23-.363-.346a6.296 6.296 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41a4.38 4.38 0 0 0 .263-.373c.118-.19.155-.385.093-.536-.28-.684-.57-1.365-.868-2.041-.059-.134-.234-.23-.393-.249-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z">
                        </path>
                    </g>
                </svg>
            </div>
            <span>{{__('lang.Email')}}</span>
        </a>
        <a href="tel:{{str_replace(' ', '', app('settings')->get('contact_phone'))}}">
            <div>
                <i class="fa-solid fa-phone"></i>
            </div>
            <span>{{__('lang.Call')}}</span>
        </a>
    </div>

</div>
