@extends('admin::layouts.master')

@section('content')
            <div class="layout-px-spacing">
                <form action="{{url('/')}}/admin/content/{{$content->type}}" method="post" enctype="multipart/form-data">
                    @method("PUT")
                    @csrf
                    <div class="page__header_title custom__page_header_title">
                        <h4>{{__('admin.content')}} {{__('admin.page')}}
                            @if($content->type == "home")
                                {{__('admin.home')}}
                            @elseif($content->type == "driver")
                                {{__('admin.cars_with_driver')}}
                            @elseif($content->type == "yacht")
                            {{__('admin.yacht_rental')}}
                            @elseif($content->type == "listcar")
                            {{__('admin.add_your_car')}}
                            @elseif($content->type == "car-types")
                                {{__('admin.Car Types')}}
                            @elseif($content->type == "car-brands")
                                {{__('admin.Car Brands')}}
                            @endif
                        </h4>
                        <button class="btn btn-primary btn-rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            {{__('admin.save')}}

                        </button>
                    </div>


                    <div class="row layout-spacing">
                        @include("admin::layouts.parts.app.alerts")


                        <div class="col-lg-12">
                            @include("admin::layouts.parts.content", [
                                "content" => $content,
                                "seo" => $seo,
                                "faq" => $faq
                            ])
                        </div>


                    </div>

                </form>



            </div>

@endsection

@section('js')
    @parent
    <script>
        (function(){
            const csrf = '{{ csrf_token() }}';
            const route = '{{ route('admin.ai.generate') }}';
            const contentType = '{{ $content->type ?? '' }}';

            function createButton(el, kind, section, lang) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-primary btn-sm mt-2';
                btn.textContent = 'Generate with AI';
                btn.addEventListener('click', async function(){
                    const basePrompt = kind === 'title' ? 'Write a concise, compelling page title' : 'Write a clear, helpful paragraph';
                    const context = ` for the ${contentType} page, section ${section}.`;
                    const userPrompt = window.prompt('Describe what to generate (optional):', '');
                    const prompt = basePrompt + context + (userPrompt ? `\nAdditional instructions: ${userPrompt}` : '');

                    btn.disabled = true;
                    const original = btn.textContent;
                    btn.textContent = 'Generating...';
                    try {
                        const res = await fetch(route, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                            },
                            body: JSON.stringify({ prompt, lang })
                        });
                        const data = await res.json();
                        if (!res.ok || data.error) throw new Error(data.error || 'Generation failed');

                        if (el.tagName.toLowerCase() === 'textarea') {
                            if (window.tinymce && Array.isArray(tinymce.editors)) {
                                const ed = tinymce.editors.find(e => e && e.targetElm === el);
                                if (ed) {
                                    ed.setContent(data.text || '');
                                } else {
                                    el.value = data.text || '';
                                }
                            } else {
                                el.value = data.text || '';
                            }
                        } else {
                            el.value = data.text || '';
                        }
                    } catch (err) {
                        alert('AI generation error: ' + (err.message || err));
                    } finally {
                        btn.disabled = false;
                        btn.textContent = original;
                    }
                });
                return btn;
            }

            function addButtons() {
                const titleInputs = document.querySelectorAll('input[name^="content_title"]');
                titleInputs.forEach(function(input){
                    const m = input.name.match(/^content_title(?:_(\d+))?_(\w+)$/);
                    const section = m && m[1] ? m[1] : '1';
                    const lang = m && m[2] ? m[2] : '';
                    const btn = createButton(input, 'title', section, lang);
                    input.insertAdjacentElement('afterend', btn);
                });

                const descAreas = document.querySelectorAll('textarea[name^="content_description"]');
                descAreas.forEach(function(area){
                    const m = area.name.match(/^content_description(?:_(\d+))?_(\w+)$/);
                    const section = m && m[1] ? m[1] : '1';
                    const lang = m && m[2] ? m[2] : '';
                    const btn = createButton(area, 'description', section, lang);
                    area.insertAdjacentElement('afterend', btn);
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', addButtons);
            } else {
                addButtons();
            }
        })();
    </script>
@endsection
