@extends('admin::layouts.master')

@section('content')

            <div class="layout-px-spacing">
                <form data-type="{{request()->get('type')}}"  action="{{url('/')}}/admin/cars" id="cars-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="page__header_title custom__page_header_title">
                        <h4>
                        {{__('admin.add')}}
                        @if(request()->get('type') == 'default')
                            {{__('admin.car')}}
                        @elseif(request()->get('type') == 'driver')
                            {{__('admin.car_with_driver')}}
                        @elseif(request()->get('type') == 'yacht')
                            {{__('admin.yacht')}}
                        @endif

                        </h4>
                        <button onclick="tinyMCE.triggerSave(true,true);" class="btn btn-primary btn-rounded submit-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            {{__('admin.save')}} 

                        </button>
                    </div>

                    <div class="row layout-spacing">
                        @include("admin::layouts.parts.app.alerts")
                        <div class="col-lg-7">
                            <div class="statbox widget box box-shadow mb-20">

                                <div class="widget-content widget-content-area">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                        <input type="hidden" name="type" value="{{request()->get('type')}}" />
                                        
                                        @if(auth()->user()->type == "admin")
                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.office_singular')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control" name="company_id" required>
                                                    <option value="">{{__('admin.office')}}</option>
                                                    @foreach(\App\Models\Company::where("type", request()->get('type'))->get() as $x)
                                                    <option value="{{$x->id}}">{{$x->name}}</option>
                                                    @endforeach
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        @else

                                        <input type="hidden" name="company_id" value="{{auth()->user()->company->id}}" />
                                        @endif

                                        @foreach(\Config::get("app.languages") as $key => $value)
                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.name')}} {{$value}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="text" required class="form-control" name="name_{{$key}}" >
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="form-group row mb-2">
                                            <div class="col-xl-3"></div>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <button type="button" id="ai-generate-car" class="btn btn-outline-primary btn-sm">{{ __('admin.generate') ?? 'Generate with AI' }}</button>
                                                <small class="text-muted d-block mt-1">Enter car name (EN), then click Generate.</small>
                                            </div>
                                        </div>

                                        @if(request('type') != 'yacht')
                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.type')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control" multiple name="type_id[]" required>
                                                   
                                                    @foreach(\App\Models\Type::all() as $x)
                                                    <option value="{{$x->id}}">{{$x->title}}</option>
                                                    @endforeach
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        @if(request('type') == 'default')

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} {{__('admin.day')}} ({{__('admin.aed')}})</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"  class="form-control" name="price_per_day" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.KM Per Day')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"  value="0"  class="form-control" name="km_per_day" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} {{__('admin.week')}} ({{__('admin.aed')}})</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"  class="form-control" name="price_per_week" >
                                            </div>
                                        </div>

                                            <div class="form-group row mb-4">
                                                <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.KM Per Week')}}</label>
                                                <div class="col-xl-9 col-lg-9 col-sm-10">
                                                    <input  type="number"  value="0"  class="form-control" name="km_per_week" >
                                                </div>
                                            </div>


                                                <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} {{__('admin.month')}} ({{__('admin.aed')}})</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"  class="form-control" name="price_per_month" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.KM Per Month')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"  value="0"  class="form-control" name="km_per_month" >
                                            </div>
                                        </div>


                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.minimum_day_booking')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number" required value="1"  class="form-control" name="minimum_day_booking" >
                                            </div>
                                        </div>



                    

                                        <!-- <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} بعد الخصم لل{{__('admin.day')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                
                                                <input  type="number"  class="form-control" name="day_offer_price" >
                                                <br/>
                                                <input style="margin-left:4px" type="checkbox" name="is_day_offer" value="1"> تفعيل {{__('admin.view')}}

                                            </div>
                                           
                                        </div> -->

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.security_deposit')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input required  type="number" class="form-control" name="security_deposit" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} {{__('admin.extra_km')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input required  type="number"  class="form-control" name="extra_price" >
                                            </div>
                                        </div>

                                        @elseif(request('type') == 'driver' || request('type') == 'yacht')

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.minimum_hours')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number" required value="1"  class="form-control" name="minimum_day_booking" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} {{__('admin.hour')}}  ({{__('admin.aed')}})</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"   class="form-control" name="price_per_day" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} 3 {{__('admin.hours')}} ({{__('admin.aed')}})</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"   class="form-control" name="price_per_week" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} 8 {{__('admin.hours')}} ({{__('admin.aed')}}) </label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number" required  class="form-control" name="price_per_month" >
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.price')}} {{__('admin.extra_hr')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <input  type="number"  class="form-control" name="extra_price" >
                                            </div>
                                        </div>


                                        @endif


                                        

                                        @foreach(\Config::get("app.languages") as $key => $value)
                                            <div class="form-group row mb-4">
                                                <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">ال{{__('admin.description')}} والمميزات {{$value}}</label>
                                                <div class="col-xl-9 col-lg-9 col-sm-10">
                                                    <textarea class="form-control" name="description_{{$key}}"></textarea>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach(\Config::get("app.languages") as $key => $value)
                                        <!-- <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">ملاحظات للعميل {{$value}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <textarea class="form-control" name="customer_notes_{{$key}}"></textarea>
                                            </div>
                                        </div> -->
                                        @endforeach

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.features')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control" multiple name="feature_id[]">
                                                   
                                                    @foreach(\App\Models\Feature::where(function($query) {
                                                        if(request('type') == "default" || request('type') == "driver") {
                                                            $query->where('type', '=', 'car');
                                                        }else {
                                                            $query->where('type', '=', 'yacht');
                                                        }

                                                    })->get() as $x)
                                                        <option value="{{$x->id}}">{{$x->name}}</option>
                                                    @endforeach
                                               
                                                  
                                                </select>
                                            </div>
                                        </div>

                                        @if(request('type') == 'default' || request('type') == 'driver')
                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.brand')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control select-brand" name="brand_id" required>
                                                    <option value="">{{__('admin.brand')}}</option>
                                                    @foreach(\App\Models\Brand::all() as $x)
                                                    <option value="{{$x->id}}">{{$x->title}}</option>
                                                    @endforeach
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.model')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control select-model" name="model_id" required>
                                                    <option value="">{{__('admin.model')}}</option>
                                                    @if(request('type') == "yacht")
                                                        @foreach(\App\Models\Models::where('type', '=', 'yacht')->get() as $x)
                                                        <option value="{{$x->id}}">{{$x->title}}</option>
                                                        @endforeach
                                                    @endif
                                                  
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        @if(request('type') == 'default' || request('type') == 'driver')
                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.color')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control" name="color_id" required>
                                                    <option value="">{{__('admin.color')}}</option>
                                                    @foreach(\App\Models\Color::all() as $x)
                                                    <option value="{{$x->id}}">{{$x->title}}</option>
                                                    @endforeach
                                                  
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.year')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <select class="form-control" name="year_id" required>
                                                    <option value="">{{__('admin.year')}}</option>
                                                    @foreach(\App\Models\Year::all() as $x)
                                                    <option value="{{$x->id}}">{{$x->title}}</option>
                                                    @endforeach
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                        

                                        <div class="form-group row mb-4">
                                            <label for="hPassword" class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.image')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" required class="custom-file-input" accept="image/*" name="image" id="customFile">
                                                    <label class="custom-file-label" for="customFile">{{__('admin.choose_file')}}</label>
                                                </div>
                                            
                                            </div>

                                        </div>                                          
                                        
                                        <div class="form-group row mb-4">
                                            <label for="hPassword" class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.other_images')}}</label>
                                            <div class="col-xl-9 col-lg-9 col-sm-10">
                                                <div id="cars-uploader"> 
                                                    <div class="dz-message" data-dz-message><span>{{__('admin.choose_file')}}</span></div>
                                                    
                                                </div>
                                        
                                            </div>

                                        </div>    
                                        
                


  

                                        
                                        
                                        </div>
                                    </div>

                                </div>
                            </div>
                      
                        </div>
                        <div class="col-lg-5">
                            <div class="statbox widget box box-shadow ">

                                <div class="widget-content widget-content-area ">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        
                                            @if(request('type') == 'default' || request('type') == 'driver')
                                            <div class="form-group row mb-4">
                                                <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.engine')}}</label>
                                                <div class="col-xl-9 col-lg-9 col-sm-10">
                                                    <input  type="text" required  class="form-control" name="engine_capacity" >
                                                </div>
                                            </div>  
                                            
                                            <div class="form-group row mb-4">
                                                <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.qty')}} {{__('admin.doors')}}</label>
                                                <div class="col-xl-9 col-lg-9 col-sm-10">
                                                    <input  type="number" required  class="form-control" name="doors" >
                                                </div>
                                            </div>     

                                            <div class="form-group row mb-4">
                                                <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.qty')}} {{__('admin.bags')}}</label>
                                                <div class="col-xl-9 col-lg-9 col-sm-10">
                                                    <input  type="number" required  class="form-control" name="bags" >
                                                </div>
                                            </div>  

                                            @endif

                                            
                                            <div class="form-group row mb-4">
                                                <label class="col-xl-3 col-sm-3 col-sm-2 col-form-label">{{__('admin.qty')}} {{request('type') == 'yacht' ? __('admin.Guests') : __('admin.passengers')}}</label>
                                                <div class="col-xl-9 col-lg-9 col-sm-10">
                                                    <input  type="number" required  class="form-control" name="passengers" >
                                                </div>
                                            </div>     
                                        
                                        </div>
                                    </div>

                                </div>
                            </div>

                            
                        </div>

                        <div class="col-lg-12">
                            @include("admin::layouts.parts.content", [
                                "content" => null,
                                "seo" => null,
                                "faq" => null,
                                "content_count" => 1
                            ])
                        </div>


                    </div>

                </form>



            </div>
<script>
(function(){
  const btn = document.getElementById('ai-generate-car');
  if (!btn) return;

  const csrf = '{{ csrf_token() }}';
  const route = '{{ route('admin.ai.generate') }}';
  const form = document.getElementById('cars-form');
  const formType = form?.getAttribute('data-type') || 'default';
  const langKeys = @json(array_keys(Config::get('app.languages')));

  function normalizeNumerals(str){
    const map = {'٠':'0','١':'1','٢':'2','٣':'3','٤':'4','٥':'5','٦':'6','٧':'7','٨':'8','٩':'9'};
    return String(str).replace(/[٠-٩]/g, d => map[d]);
  }
  function toNumber(val){
    if (val === null || val === undefined || val === '') return '';
    const cleaned = normalizeNumerals(String(val)).replace(/[^0-9.\-]/g, ''); 
    const n = Number(cleaned);
    return isNaN(n) ? '' : n;
  }

  function setInput(name, value){
    const el = document.querySelector(`[name="${name}"]`);
    if (!el) return;
    el.value = value ?? '';
    el.dispatchEvent(new Event('input', { bubbles: true }));
    el.dispatchEvent(new Event('change', { bubbles: true }));
  }
  function setTextarea(name, value){
    const el = document.querySelector(`textarea[name="${name}"]`);
    if (!el) return;
    el.value = value ?? '';
    el.dispatchEvent(new Event('input', { bubbles: true }));
    el.dispatchEvent(new Event('change', { bubbles: true }));
  }

  function setTinyOrTextarea(name, html){
    
    const el = document.querySelector(`[name="${name}"]`);
    if (!el) return;
    if (window.tinymce) {
        const inst = window.tinymce.get(el.name) || window.tinymce.get(el.id);
        if (inst) {
            inst.setContent(html || 'Ahmed');
            inst.fire('change');
            return;
        }
    }
  }

  function setMultiSelectByTexts(selector, texts){
    const select = document.querySelector(selector);
    if (!select) return;
    const wanted = Array.isArray(texts) ? texts.map(String) : [];
    const values = [];
    for (const opt of select.options) {
      const t = (opt.text || '').toLowerCase().trim();
      if (wanted.some(w => {
        const ww = String(w).toLowerCase().trim();
        return t === ww || t.startsWith(ww) || t.includes(ww);
      })) values.push(opt.value);
    }
    // select2
    if (window.$ && $(select).hasClass('select2-hidden-accessible')) {
      $(select).val(values).trigger('change');
    } else {
      for (const opt of select.options) {
        opt.selected = values.includes(opt.value);
      }
      select.dispatchEvent(new Event('change', { bubbles: true }));
    }
  }

  function setSelectByText(select, text){
    if (!select || !text) return null;
    const target = String(text).toLowerCase().trim();
    let chosen = null;
    const opts = Array.from(select.options || []);
    chosen = opts.find(o => (o.text || '').toLowerCase().trim() === target)
         ||  opts.find(o => (o.text || '').toLowerCase().trim().startsWith(target))
         ||  opts.find(o => (o.text || '').toLowerCase().trim().includes(target));
    if (chosen) {
      const value = chosen.value;
      if (window.$ && $(select).hasClass('select2-hidden-accessible')) {
        $(select).val(value).trigger('change');
      } else {
        select.value = value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
      }
      return chosen;
    }
    return null;
  }

  async function setModelByName(brandId, modelName){
    if (!brandId || !modelName) return;
    try {
      const res = await fetch(`/admin/cars/${brandId}/models`, { headers:{'Accept':'application/json'} });
      const data = await res.json();
      const select = document.querySelector('select.select-model[name="model_id"]');
      if (!select) return;
      const wasSelect2 = window.$ && $(select).hasClass('select2-hidden-accessible');
      if (wasSelect2) $(select).select2('destroy');
      select.innerHTML = `<option value="">{{ __('admin.model') }}</option>`;
      (data || []).forEach(m=>{
        const opt = document.createElement('option');
        opt.value = m.id;
        opt.textContent = m.name || m.title || '';
        select.appendChild(opt);
      });
      if (wasSelect2) {
        $(select).select2({ dir: 'rtl', width: '100%', dropdownAutoWidth: true, dropdownParent: $(select).parent() });
      }
      setSelectByText(select, modelName);
    } catch(_) {}
  }

  function setKeywordsCSV(name, list){
    const val = Array.isArray(list) ? list.map(s => String(s).trim()).filter(Boolean) : [];
    const csv = val.join(', ');
    setTextarea(name, csv);
  }

  btn.addEventListener('click', async function(){
    const nameEnEl = document.querySelector('[name="name_en"]');
    const nameEn = nameEnEl ? nameEnEl.value.trim() : '';
    if (!nameEn) { alert('Please enter the car name (EN) first.'); return; }

    const prompt = [
      `You are helping fill an admin rental form for a ${formType === 'yacht' ? 'yacht' : (formType === 'driver' ? 'car-with-driver' : 'self-drive car')} in the UAE, Act as human and give me fresh content and unique, DO NOT repeat any text, Content seo optimization`,
      `Car name: "${nameEn}".`,
      'Return STRICT minified JSON that matches the responseSchema. No markdown, no comments, no trailing commas.',
      'Write short descriptions (max 100 words) for ar, en, ru. Each must mention "TAJEER RENT A CAR" and "car rental in Dubai". Map to description_ar, description_en, description_ru.',
      'Create 3 long HTML content blocks for each language (ar, en, ru):',
      '- Block 1: specifications & advantages',
      '- Block 2: brand and model details',
      '- Block 3: why rent this vehicle in Dubai',
      'Create SEO meta title per language (ar, en, ru) → seo_meta_title_{lang}.',
      'Create meta description per language (≤130 chars) → seo_description_{lang}.',
      'Create up to 5 SEO keywords per language → seo_keywords_{lang} (array).',
      'Keep numeric fields as numbers. Use AED. For driver/yacht: minimum_day_booking is hours; for self-drive: days.'
    ].join('\n');

    btn.disabled = true;
    const original = btn.textContent;
    btn.textContent = '{{ __('admin.generating') ?? 'Generating...' }}';

    try {
      const res = await fetch(route, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify({ prompt })
      });
      const data = await res.json();
      if (!res.ok || data.error) throw new Error(data.error || 'Generation failed');

      // server returns parsed JSON
      const parsed = data.json || {};

      // ==== Names & short descriptions ====
      (['ar','en','ru']).forEach(l=>{
        if (parsed[`name_${l}`] != null) setInput(`name_${l}`, String(parsed[`name_${l}`]));
        if (parsed[`description_${l}`] != null) setTextarea(`description_${l}`, String(parsed[`description_${l}`]));
      });

      // ==== Long HTML content (3 blocks) ====
        (['ar','en','ru']).forEach(l=>{
          const tKey = `content_title_${l}`;
          const dKey = `content_description_${l}`;
          if (parsed[tKey] != null) setInput(`content_title_${l}`, String(parsed[tKey]));
          if (parsed[dKey] != null) setTinyOrTextarea(`content_description_${l}`, String(parsed[dKey]));
        });

      // ==== Numbers ====
      if (formType === 'default') {
        setInput('price_per_day',   toNumber(parsed.price_per_day));
        setInput('price_per_week',  toNumber(parsed.price_per_week));
        setInput('price_per_month', toNumber(parsed.price_per_month));
        setInput('km_per_day',      toNumber(parsed.km_per_day));
        setInput('km_per_week',     toNumber(parsed.km_per_week));
        setInput('km_per_month',    toNumber(parsed.km_per_month));
      } else {
        setInput('price_per_day',   toNumber(parsed.price_per_hour));
        setInput('price_per_week',  toNumber(parsed.price_3_hours));
        setInput('price_per_month', toNumber(parsed.price_8_hours));
      }
      setInput('extra_price',           toNumber(parsed.extra_price));
      setInput('minimum_day_booking',   toNumber(parsed.minimum_day_booking));

      if (formType !== 'yacht') {
        setInput('engine_capacity', parsed.engine_capacity || '');
        setInput('doors',           toNumber(parsed.doors));
        setInput('bags',            toNumber(parsed.bags));
      }
      setInput('passengers', toNumber(parsed.passengers));


      // ==== SEO (your exact names) ====
      (['ar','en','ru']).forEach(l=>{
        if (parsed[`seo_meta_title_${l}`] != null) setInput(`seo_meta_title_${l}`, String(parsed[`seo_meta_title_${l}`]));
        if (parsed[`seo_description_${l}`] != null) setTextarea(`seo_description_${l}`, String(parsed[`seo_description_${l}`]));
        if (parsed[`seo_keywords_${l}`]) setKeywordsCSV(`seo_keywords_${l}`, parsed[`seo_keywords_${l}`]);
      });

      if (Array.isArray(parsed.faq) && parsed.faq.length){
        const holder = document.querySelector('.faq__holder');
        const addBtn = document.querySelector('.add-faq');
        const need = parsed.faq.length - holder.querySelectorAll('.faq__item').length;
        for (let i=0; i<need; i++){
          try { addBtn?.dispatchEvent(new Event('click', {bubbles:true})); } catch(_) {}
        }
        const qSel = l => `input[name="faq_question_${l}[]"]`;
        const aSel = l => `input[name="faq_answer_${l}[]"]`;
        parsed.faq.forEach((item, idx)=>{
          (['ar','en','ru']).forEach(l=>{
            const q = document.querySelectorAll(qSel(l))[idx];
            const a = document.querySelectorAll(aSel(l))[idx];
            if (q && item[`question_${l}`] != null) q.value = String(item[`question_${l}`]);
            if (a && item[`answer_${l}`]   != null) a.value = String(item[`answer_${l}`]);
          });
        });
      }

    } catch (err) {
      alert('AI generation error: ' + (err.message || err));
    } finally {
      btn.disabled = false;
      btn.textContent = original;
    }
  });
})();
</script>
@endsection