    @if(count($faq) > 0)
        <section>
            <div class="container mt-5">
                <h2>{{__('lang.FAQ')}}</h2>
            </div>
            <div class="conatiner">
                <div class="container accordion accordion-flush custom-accordion" id="faqsFlushExample">
                    @foreach ($faq as $item)
                        <div class="accordion-item">
                            <h4 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne-faq-{{$item->id}}" aria-expanded="false"
                                        aria-controls="#collapseOne-faq-{{$item->id}}">
                                    {{$item->question}}
                                    <span class="accordion-btn">
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </span>
                                </button>
                            </h4>
                            <div id="collapseOne-faq-{{$item->id}}" class="accordion-collapse collapse"
                                 aria-labelledby="flush-headingOne" data-bs-parent="#faqsFlushExample">
                                <div class="accordion-body">
                                    {!! $item->answer !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif