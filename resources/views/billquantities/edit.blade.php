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
    <label for="type" class="col-md-3 control-label">{{ trans('admin/billquantities/table.type') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-7" >
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


<!-- type  -->
<div class="form-group {{ $errors->has('type') ? ' has-error' : '' }}">
    <label for="type" class="col-md-3 control-label">{{ trans('admin/billquantities/table.categories') }}</label>

    <div class="col-md-8">
        {{-- <label for="modelNo" class="col-md-3 control-label">{{ trans('admin/billquantities/table.type') }}</label> --}}
        <div class="input-group col-md-12" >
              <input type="radio" id="contract" name="type" value="Services">
              <label for="Services">Services </label>

              <input type="radio" id="software" name="type" value="Software">
              <label for="Software">Software</label>


              <input type="radio" id="Training" name="type" value="Training">
              <label for="Training">Training</label>   

              <input type="radio" id="Equiment" name="type" value="Equiment">
              <label for="Equiment">Equiment</label>        

            

                     
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('type', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>   

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif

<!-- Brand  -->
<div class="form-group {{ $errors->has('brand') ? ' has-error' : '' }}">
    <label for="modelNo" class="col-md-3 control-label">{{ trans('admin/billquantities/table.brand') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="brand" id="generateidtxt" value="{{ Request::old('brand', $item->brand) }}" />
        </div>
        <div class="col-md-1 col-sm-2 text-left">

            {{-- <button type="button"  id="generateID" class="btn btn-primary">Generate</button> --}}

            {{-- <button id="generateID">Generate </button> --}}
        </div>
        
    </div>
    {!! $errors->first('serial', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>



<!-- model no -->
<div class="form-group {{ $errors->has('modelNo') ? ' has-error' : '' }}">
    <label for="modelNo" class="col-md-3 control-label">{{ trans('admin/billquantities/table.modelNo.') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12 {{  (\App\Helpers\Helper::checkIfRequired($item, 'modelNo')) ? ' required' : '' }} "  style="padding-left:0px">
            <input class="form-control" type="text" name="modelNo" id="generateidtxt" value="{{ Request::old('modelNo', $item->modelNo) }}" {!!  (\App\Helpers\Helper::checkIfRequired($item, 'modelNo')) ? ' data-validation="required" required' : '' !!} />
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
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="serial" id="generateidtxt" value="{{ Request::old('serial', $item->serial) }}" />
        </div>
        <div class="col-md-1 col-sm-2 text-left">

            {{-- <button type="button"  id="generateID" class="btn btn-primary">Generate</button> --}}

            {{-- <button id="generateID">Generate </button> --}}
        </div>
        
    </div>
    {!! $errors->first('serial', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>
 
<!-- Descriptopn  -->
<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="serial" class="col-md-3 control-label">{{ trans('admin/billquantities/table.description') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="name" id="generateidtxt" value="{{ Request::old('name', $item->name) }}" />
        </div>
        <div class="col-md-1 col-sm-2 text-left">

            {{-- <button type="button"  id="generateID" class="btn btn-primary">Generate</button> --}}

            {{-- <button id="generateID">Generate </button> --}}
        </div>
        
    </div>
    {!! $errors->first('serial', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>

{{-- @include ('partials.forms.edit.name', ['translated_name' => trans('admin/billquantities/table.description')]) --}}


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
 
<!-- filename -->
<div class="form-group {{ $errors->has('filename') ? ' has-error' : '' }}">
    <label for="filename" class="col-md-3 control-label">Filename</label>
    <div class="col-md-7 col-sm-12">
        {{-- <div class="col-xs-3"> --}}
    <input class="form-control" type="text" name="filename" aria-label="filename" id="filename" value="{{ old('filename', $item->filename) }}"/>
  </div>
  {!! $errors->first('filename', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Select Files</label>
    <div class="col-md-7 col-sm-12">
        <input type="file" name="file" class="custom-file-input" id="chooseFile">    
        <p >only csv,txt,xlx,xls,pdf type file, and 5Mb</p>

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
