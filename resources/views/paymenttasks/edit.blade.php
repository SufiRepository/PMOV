@extends('layouts/edit-form', [
    'createText' => trans('Create payment schedule') ,
    'updateText' => trans('Update payment schedule'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.paymenttasks'),
    'formAction' => (isset($item->id)) ? route('paymenttasks.update', ['paymentschedule' => $item->id]) : route('paymenttasks.store'),
])
{{-- Page content --}}
@section('inputFields')

{{-- @include ('partials.forms.edit.name', ['translated_name' => trans('Name')]) --}}

{{-- project id  --}}

<input type="hidden" id="payment" name="payment" value="PAID">

{{-- @include ('partials.forms.edit.contractor-select', ['translated_name' => trans('general.contractors'), 'fieldname' => 'contractor_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id']) --}}

@foreach ($tasks as $task)
<input type="hidden" id="task_id" name="task_id" value="{{ $task->id }}">
<input type="hidden" id="task_id" name="contractor_id" value="{{ $task->contractor_id}}">
<input type="hidden" id="task_id" name="supplier_id" value="{{ $task->supplier_id}}">

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Milestone</label>
    <div class="col-md-7 col-sm-12">
        <label for="files" class="col-md-3 control-label">{{ $task->name}}</label>
    </div>
</div>
{{-- contractor --}}

@if (!is_null($task->contractor))
<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">contractor</label>
    <div class="col-md-7 col-sm-12">
        <label for="files" class="col-md-3 control-label">{{ $task->contractor->name}}</label>
    </div>
</div>
@endif
{{-- supplier --}}
@if (!is_null($task->supplier))
<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Supplier</label>
    <div class="col-md-7 col-sm-12">
        <label for="files" class="col-md-3 control-label">{{ $task->supplier->name}}</label>
    </div>
</div>
@endif
@endforeach  


 <!-- Purchase order -->
<div class="form-group {{ $errors->has('purchase_order') ? ' has-error' : '' }}">
    <label for="purchase_order" class="col-md-3 control-label">Purchase Order</label>
    <div class="col-md-7 col-xs-3">
        {{-- <div class="col-xs-3"> --}}
    <input class="form-control" type="text" name="purchase_order" aria-label="purchase_order" id="purchase_order" value="{{ old('purchase_order', $item->purchase_order) }}"/>
  {{-- </div> --}}
  {!! $errors->first('purchase_order', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Select Files</label>
    <div class="col-md-7 col-sm-12">
        <input type="file" name="file" class="custom-file-input" id="chooseFile">
    </div>
    
</div>
 <!-- end Purchase order -->

 <!-- delivery  order -->
 <div class="form-group {{ $errors->has('delivery_order') ? ' has-error' : '' }}">
    <label for="delivery_order" class="col-md-3 control-label">delivery order</label>
    <div class="col-md-7 col-xs-3">
        {{-- <div class="col-xs-3"> --}}
    <input class="form-control" type="text" name="delivery_order" aria-label="delivery_order" id="delivery_order" value="{{ old('delivery_order', $item->delivery_order) }}"/>
  {{-- </div> --}}
  {!! $errors->first('delivery_order', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Select Files</label>
    <div class="col-md-7 col-sm-12">
        <input type="file" name="delivery_order_file" class="custom-file-input" id="chooseFile">
    </div>
    
</div>
 <!-- end delivery  order -->

  <!-- supported documents  order -->
  <div class="form-group {{ $errors->has('supported_documents') ? ' has-error' : '' }}">
    <label for="supported_documents" class="col-md-3 control-label">supported documents</label>
    <div class="col-md-7 col-xs-3">
        {{-- <div class="col-xs-3"> --}}
    <input class="form-control" type="text" name="supported_documents" aria-label="supported_documents" id="supported_documents" value="{{ old('supported_documents', $item->supported_documents) }}"/>
  {{-- </div> --}}
  {!! $errors->first('supported_documents', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
    <label for="files" class="col-md-3 control-label">Select Files</label>
    <div class="col-md-7 col-sm-12">
        <input type="file" name="supported_documents" class="custom-file-input" id="chooseFile">
    </div>
    
</div>
 <!-- end supported documents  -->

 <!-- Purchase Cost -->
<div class="form-group {{ $errors->has('costing') ? ' has-error' : '' }}">
    <label for="costing" class="col-md-3 control-label">{{ trans('admin/paymentschedules/form.payments') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input class="form-control" type="text" name="costing" aria-label="costing" id="costing" value="{{ old('costing', \App\Helpers\Helper::formatCurrencyOutput($item->costing)) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('costing', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>

 <!-- details -->
<div class="form-group {{ $errors->has('details') ? ' has-error' : '' }}">
    <label for="details" class="col-md-3 control-label">Details</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="details" aria-label="details" name="details">{{ old('details', $item->details) }}</textarea>
        {!! $errors->first('details', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>


<script nonce="{{ csrf_token() }}">

</script>

{{-- end add --}}
@stop
