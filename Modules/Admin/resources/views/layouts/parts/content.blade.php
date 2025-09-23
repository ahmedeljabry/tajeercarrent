<div class="mt-20 fb">
    @php
        $content_count ??= 3;
    @endphp
    @for($i = 1; $i <= $content_count; $i++)
        <div class="statbox widget box box-shadow mt-20">
            <div class="widget-header mb-20">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <div class="page__header_title">
                            <h4>{{__('admin.content')}} {{$i}}</h4>
                        </div>

                    </div>
                </div>
            </div>

            <div class="widget-content widget-content-area">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            @foreach(\Config::get("app.languages") as $key => $value)
                                <div class="col-lg-6">
                                    <div class="form-group row mb-4">
                                        <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.title')}}  {{$value}}</label>
                                        <div class="col-xl-12 col-lg-12 col-sm-12">
                                            <input type="text" value="{{$content ? $content->getTranslation('title'.($i > 1 ? "_{$i}" : ""), $key) : ''}}"  class="form-control" name="content_title{{$i > 1 ? "_$i":''}}_{{$key}}" >
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="form-group row mb-4">
                            <label for="hPassword" class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.image')}} {{__('admin.content')}}</label>
                            <div class="col-xl-12 col-lg-12 col-sm-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="image/*" name="content_image{{$i > 1 ? "_$i":''}}" id="customFileContent{{$i}}">
                                    <label class="custom-file-label" for="customFileContent{{$i}}">{{__('admin.choose_file')}}</label>
                                </div>
                                @if($content && $content->{"image" . ($i > 1 ? "_{$i}" : "")})
                                    <img src="{{asset('storage/'.\App\Helpers\WebpImage::generateUrl($content->{"image" . ($i > 1 ? "_{$i}" : "")}))}}" class="img-fluid mt-2" style="max-width: 200px;">
                                    <br/>
                                    <a href="{{url('/')}}/admin/content/delete-image/{{$content->id}}/{{$i}}" class="btn btn-danger btn-rounded mt-2">{{__('admin.delete')}} {{__('admin.image')}}</a>
                                @endif
                            </div>
                        </div>


                        @foreach(\Config::get("app.languages") as $key => $value)
                            <div class="form-group row mb-4">
                                <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.content')}} {{$value}}</label>
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <textarea  class="form-control body" name="content_description{{$i > 1 ? "_$i":''}}_{{$key}}" >{!!$content ? $content->getTranslation('description' . ($i > 1 ? "_{$i}" : ""), $key) : '' !!}</textarea>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endfor

    <div class="statbox widget box box-shadow mt-20">
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">


                        @if($seo && ( $seo->type == "yacht" || $seo->type == "driver" || $seo->type == "listcar"))
                            @foreach(\Config::get("app.languages") as $key => $value)

                                    <div class="form-group row mb-4">
                                        <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.title')}} {{__('admin.page')}} {{$value}}</label>
                                        <div class="col-xl-12 col-lg-12 col-sm-12">
                                            <input type="text" value="{{$seo ? $seo->getTranslation('meta_title', $key) : ''}}"  class="form-control" name="seo_meta_title_{{$key}}" >
                                        </div>
                                    </div>

                            @endforeach
                        @endif

                    @foreach(\Config::get("app.languages") as $key => $value)
                    <div class="form-group row mb-4">
                        <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.description')}} {{__('admin.seo')}} {{$value}}</label>
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <textarea  class="form-control" name="seo_description_{{$key}}" >{!!$seo ? $seo->getTranslation('description', $key) : '' !!}</textarea>
                        </div>
                    </div>
                    @endforeach

                    @foreach(\Config::get("app.languages") as $key => $value)
                    <div class="form-group row mb-4">
                        <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.keywords')}} {{__('admin.seo')}} {{$value}}</label>
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <textarea  class="form-control" name="seo_keywords_{{$key}}" >{!!$seo ? $seo->getTranslation('keywords', $key) : '' !!}</textarea>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <div class="statbox widget box box-shadow mt-20">
        <div class="widget-header mb-20">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="page__header_title">
                        <h4>{{__('admin.faq')}}</h4>
                        <button type="button" class="btn btn-primary btn-rounded add-faq">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            {{__('admin.add')}}

                        </button>
                    </div>

                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="row">
                <div class="col-lg-12 faq__holder">
                    @if($faq && count($faq) > 0)
                        @foreach($faq as $f)
                            <div class="faq__item">
                                <div class="row">
                                    @foreach(\Config::get("app.languages") as $key => $value)
                                        <div class="col-lg-6">
                                            <div class="form-group row mb-4">
                                                <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.question')}} {{$value}}</label>
                                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                                    <input type="text" value="{{$f->getTranslation('question', $key)}}"  class="form-control" name="faq_question_{{$key}}[]" >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @foreach(\Config::get("app.languages") as $key => $value)
                                        <div class="col-lg-6">
                                            <div class="form-group row mb-4">
                                                <label class="col-xl-12 col-sm-12 col-sm-12 col-form-label">{{__('admin.answer')}} {{$value}}</label>
                                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                                    <input type="text" value="{{$f->getTranslation('answer', $key)}}"  class="form-control" name="faq_answer_{{$key}}[]" >
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-danger mt-20 btn-rounded remove-faq">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            {{__('admin.delete')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
    tinymce.init({   
        license_key: 'gpl',
        selector: 'textarea.body',
        directionality: "rtl",
        plugins: 'autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
    </script>
@endsection


