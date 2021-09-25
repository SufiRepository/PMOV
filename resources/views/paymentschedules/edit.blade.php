@extends('layouts/edit-form', [
    'createText' => trans('Create payment schedule') ,
    'updateText' => trans('Update payment schedule'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.paymentschedules'),
    'formAction' => (isset($item->id)) ? route('paymentschedules.update', ['paymentschedule' => $item->id]) : route('paymentschedules.store'),
])
{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('Name')])

{{-- project id  --}}
<input type="hidden" id="implementationplan_id" name="implementationplan_id" value="{{request()->get('id')}}">

@include ('partials.forms.edit.contractor-select', ['translated_name' => trans('general.contractors'), 'fieldname' => 'contractor_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])



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
