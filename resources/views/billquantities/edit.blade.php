@extends('layouts/edit-form', [
    'createText' => trans('admin/billquantities/table.create') ,
    'updateText' => trans('admin/billquantities/table.update'),
    'helpTitle' => trans('admin/billquantities/table.about_billquantities_title'),
    'helpText' => trans('admin/billquantities/table.about_billquantities_text'),
    
    'formAction' => (isset($item->id)) ? route('billquantities.update', ['billquantity' => $item->id]) : route('billquantities.store'),
    // 'formAction' => (isset($item->id)) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store'),

])


{{-- Page content --}}
@section('inputFields')

<input type="hidden" id="project" name="project_id" value="{{request()->get('id')}}">

<!-- type  -->
<div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
    <label for="type" class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="input-group col-md-7" style="padding-left: 0px;">

            <input type="radio" id="contract" name="option" value="Contract">
              <label for="contract">Contract</label>
              <input type="radio" id="non_contract" name="option" value="Non Contract">
              <label for="non_contract">Non Contract</label><br>    

        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('type', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>    

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/billquantities/table.description')])

<!-- type  -->
<div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
    <label for="type" class="col-md-3 control-label">{{ trans('') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input type="radio" id="contract" name="type" value="Services">
              <label for="Services">Services </label>

              <input type="radio" id="Equiment" name="type" value="Equiment">
              <label for="Equiment">Equiment</label>        

              <input type="radio" id="software" name="type" value="Software">
              <label for="Software">Software</label><br>         
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('type', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>   

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif

<!-- model no -->
<div class="form-group {{ $errors->has('modelNo') ? ' has-error' : '' }}">
    <label for="modelNo" class="col-md-3 control-label">{{ trans('admin/billquantities/table.modelNo.') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-7" style="padding-left:0px">
            <input class="form-control" type="text" name="modelNo" id="generateidtxt" value="{{ Request::old('modelNo', $item->modelNo) }}" />
        </div>
        <div class="col-md-1 col-sm-2 text-left">

            {{-- <button type="button"  id="generateID" class="btn btn-primary">Generate</button> --}}

            {{-- <button id="generateID">Generate </button> --}}
        </div>
        
    </div>
    {!! $errors->first('serial', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>

<!-- serial No. -->
<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
    <label for="serial" class="col-md-3 control-label">{{ trans('admin/accessories/table.serial_No') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-7" style="padding-left:0px">
            <input class="form-control" type="text" name="serial" id="generateidtxt" value="{{ Request::old('serial', $item->serial) }}" />
        </div>
        <div class="col-md-1 col-sm-2 text-left">

            {{-- <button type="button"  id="generateID" class="btn btn-primary">Generate</button> --}}

            {{-- <button id="generateID">Generate </button> --}}
        </div>
        
    </div>
    {!! $errors->first('serial', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>
 
{{-- <p>Enter First Number :</p>
<br>
<input type="text" id="Text1"  oninput="add_number()">
<br> <p>Enter Second Number :</p>
<br>
<input type="text" id="Text2"  oninput="add_number()">
<br>Result :
<br> --}}



<!-- sale value  -->
<div class="form-group {{ $errors->has('sale_value') ? ' has-error' : '' }}">
    <label for="sale_value" class="col-md-3 control-label">{{ trans('general.selling_price') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">

            {{-- <input type="text" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)" /> --}}

            <input class="form-control" type="text" name="sale_value"   id="Text1" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)"  oninput="add_number()"   aria-label="sale_value"  value="{{ old('sale_value', \App\Helpers\Helper::formatCurrencyOutput($item->sale_value)) }}" />
          
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('sale_value', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>

<!-- buy value  -->
<div class="form-group {{ $errors->has('buy_value') ? ' has-error' : '' }}">
    <label for="buy_value" class="col-md-3 control-label">{{ trans('general.cost_price') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">

            {{-- <input type="text" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)" /> --}}

            <input class="form-control" type="text" name="buy_value" id="Text2" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)"  oninput="add_number()" aria-label="buy_value"  value="{{ old('buy_value', \App\Helpers\Helper::formatCurrencyOutput($item->buy_value)) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('buy_value', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>

<!-- net profit  -->
{{-- <div class="form-group {{ $errors->has('net_profit') ? ' has-error' : '' }}">
    <label for="net_profit" class="col-md-3 control-label">{{ trans('general.net_profit') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">

            <input class="form-control" type="text" name="net_profit" id="txtresult"  aria-label="net_profit"   value="{{ old('net_profit', \App\Helpers\Helper::formatCurrencyOutput($item->net_profit)) }}" readonly />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('net_profit', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div> --}}

@include ('partials.forms.edit.remark')

{{-- @include ('partials.forms.edit.sale_value') --}}

{{-- @include ('partials.forms.edit.buy_value') --}}
 <!-- Image -->
 @if ($item->image)
 <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
     <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
     <div class="col-md-5">
         <label class="control-label" for="image_delete">
         <input type="checkbox" value="1" name="image_delete" id="image_delete" class="minimal" {{ Request::old('image_delete') == '1' ? ' checked="checked"' : '' }}>
         {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
         </label>
         <div style="margin-top: 0.5em">
             <img src="{{ Storage::disk('public')->url(app('assets_upload_path').e($item->image)) }}" class="img-responsive" />
         </div>
     </div>
 </div>
 @endif

 <div class="form-group {{ $errors->has((isset($fieldname) ? $fieldname : 'image')) ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.upload') }}</label>
    <div class="col-md-9">

        <input type="file" id="image" name="{{ (isset($fieldname) ? $fieldname : 'image') }}" aria-label="image" class="sr-only">

        <label class="btn btn-default" aria-hidden="true">
            {{ trans('button.select_file')  }}
            <input type="file" name="{{ (isset($fieldname) ? $fieldname : 'image') }}" class="js-uploadFile" id="uploadFile" data-maxsize="{{ \App\Helpers\Helper::file_upload_max_size() }}" accept="image/gif,image/jpeg,image/webp,image/png,image/svg" style="display:none; max-width: 90%" aria-label="image" aria-hidden="true">
        </label>
        <span class='label label-default' id="uploadFile-info"></span>

        <p class="help-block" id="uploadFile-status">{{ trans('general.image_filetypes_help', ['size' => \App\Helpers\Helper::file_upload_max_size_readable()]) }}</p>
        {!! $errors->first('image', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
    <div class="col-md-4 col-md-offset-3" aria-hidden="true">
        <img id="uploadFile-imagePreview" style="max-width: 200px; display: none;" alt="Uploaded image thumbnail">
    </div>
</div>




<script>
    var text1 = document.getElementById("Text1");
    var text2 = document.getElementById("Text2");

    function add_number() {
    var first_number = parseFloat(text1.value);
    if (isNaN(first_number)) first_number = 0;
    var second_number = parseFloat(text2.value);
    if (isNaN(second_number)) second_number = 0;
    var result = first_number - second_number;
    document.getElementById("txtresult").value = result;
    }

    const generateID = () =>
    Date.now().toString(Math.floor(Math.random() * 20) + 17);
      
    const btnGenerate = document.getElementById('generateID');
    const generateIDTXT = document.getElementById('generateidtxt');
    const copy = document.getElementById('copy');
    
    btnGenerate.addEventListener('click', () => {
      generateIDTXT.value = generateID();
    });
    

        function FormatCurrency(ctrl) {
            //Check if arrow keys are pressed - we want to allow navigation around textbox using arrow keys
            if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
                return;
            }
    
            var val = ctrl.value;
    
            val = val.replace(/,/g, "")
            ctrl.value = "";
            val += '';
            x = val.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
    
            var rgx = /(\d+)(\d{3})/;
    
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
    
            ctrl.value = x1 + x2;
        }
    
        function CheckNumeric() {
            return event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 46;
        }
    
    </script>
@stop
