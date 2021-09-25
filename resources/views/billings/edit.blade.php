@extends('layouts/edit-form', [
    'createText' => trans('Create billing') ,
    'updateText' => trans('Update billing'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.billings'),
    'formAction' => (isset($item->id)) ? route('billings.update', ['billing' => $item->id]) : route('billings.store'),
])
{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('Name')])


{{-- task id  --}}
{{-- <input type="hidden" id="task" name="task_id" value="{{request()->get('id')}}"> --}}
 
@include ('partials.forms.edit.task-select', ['translated_name' => trans('general.contractors'), 'fieldname' => 'contractor_id'])


<!-- details -->
<div class="form-group {{ $errors->has('details') ? ' has-error' : '' }}">
    <label for="details" class="col-md-3 control-label">Details</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="details" aria-label="details" name="details">{{ old('details', $item->details) }}</textarea>
        {!! $errors->first('details', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>


 <!-- Purchase Cost -->
<div class="form-group {{ $errors->has('costing') ? ' has-error' : '' }}">
    <label for="costing" class="col-md-3 control-label">Bill Value</label>
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

 
<!-- billing date   -->
<div class="form-group {{ $errors->has('billing_date') ? ' has-error' : '' }}">
    <label for="billing_date" class="col-md-3 control-label">Billing Date</label>
    <div class="input-group col-md-3">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                   <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="billing_date" id="billing_date" value="{{ old('billing_date', ($item->billing_date) ? $item->billing_date->format('Y-m-d') : '') }}">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
    </div>
 </div>


<script nonce="{{ csrf_token() }}">

</script>

{{-- end add --}}
@stop
