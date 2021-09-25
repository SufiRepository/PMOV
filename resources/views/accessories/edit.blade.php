@extends('layouts/edit-form', [
    'createText' => trans('admin/accessories/general.create') ,
    'updateText' => trans('admin/accessories/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.accessories'),
    'formAction' => (isset($item->id)) ? route('accessories.update', ['accessory' => $item->id]) : route('accessories.store'),
])

{{-- Page content --}}
@section('inputFields')
{{-- create control view for selected  collum  --}}

{{-- @can('viewColumn', \App\Models\Accessory::class)
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endcan

@can('viewColumnDisabled', \App\Models\Accessory::class)
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endcan --}}

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif

 
 
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/accessories/general.accessory_name')])

<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
    <label for="serial" class="col-md-3 control-label">{{ trans('admin/accessories/table.serial_No') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-7" style="padding-left:0px">
            <input class="form-control" type="text" name="serial" id="generateidtxt" value="{{ Request::old('serial', $item->serial) }}" />
        </div>
        <div class="col-md-1 col-sm-2 text-left">

            <button type="button"  id="generateID" class="btn btn-primary">Generate</button>

            {{-- <button id="generateID">Generate </button> --}}
        </div>
        
    </div>
    {!! $errors->first('serial', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>

{{-- add by farez  17/5 --}}
{{-- project id  --}}
<input type="hidden" id="project" name="project_id" value="{{request()->get('id')}}">

{{-- end add --}}

@include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id', 'required' => 'true','category_type' => 'accessory'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
{{-- @include ('partials.forms.edit.model_number') --}}




@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.purchase_cost')
@include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')


<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            {{ Form::checkbox('image_delete') }}
            <img src="{{  Storage::disk('public')->url('accessories/'.e($item->image)) }}" class="img-responsive" />
            {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
        </div>
    </div>
@endif

@include ('partials.forms.edit.image-upload')

<script>
    const generateID = () =>
    Date.now().toString(Math.floor(Math.random() * 20) + 17);
      
    const btnGenerate = document.getElementById('generateID');
    const generateIDTXT = document.getElementById('generateidtxt');
    const copy = document.getElementById('copy');
    
    btnGenerate.addEventListener('click', () => {
      generateIDTXT.value = generateID();
    });
    
    </script>

@stop
