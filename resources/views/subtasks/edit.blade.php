@extends('layouts/edit-form', [
    
    'createText' => trans('admin/subtasks/form.create_subtask') ,
    'updateText' => trans('admin/subtasks/form.update_subtask'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.subtasks'),
    'formAction' => (isset($item->id)) ? route('subtasks.update', ['subtask' => $item->id]) : route('subtasks.store'),
])
{{-- Page content --}}
@section('inputFields')

@foreach ($tasks as $task)
<input type="hidden" id="project" name="task_id" value="{{ $task->id }}">
<input type="hidden" id="task" name="project_id" value="{{ $task->project_id }}">

<input type="hidden" id="subtasks" name="subtasks" value="{{ $task->subtasks}}">

@endforeach  

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/subtasks/form.subtask')])

@include ('partials.forms.edit.value3')


<div class="form-group col-xs-12 col-sm-12 col-md-12">
  <label for="costing" class="col-md-3 control-label">{{trans('admin/subtasks/form.billingscedule')}}</label>
  <div class="col-md-9">
      <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
          <input type="month" id="bdaymonth" name="payment_month">
      </div>
  </div>
</div>

@include ('partials.forms.edit.contractor-select', ['translated_name' => trans('general.contractors'), 'fieldname' => 'contractor_id'])

@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">Priority:</label>
        <div class="col-md-9">
            <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                <select class="form-control" name="priority" style="width: 100%">
                    <option ></option>
                    <option value="High" >High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>  
                </select>
            </div>
        </div>
</div>

{{-- @include ('partials.forms.edit.status') --}}

<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">{{trans('admin/subtasks/form.status')}}</label>
    <div class="col-md-9">
        <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
            <select class="form-control" name="statustask_id" style="width: 100%">
                @foreach ($statustasks as $statustask)
                    <option  value="{{ $statustask->id }}"> 
                        {{ $statustask->name }} 
                    </option>
                @endforeach    
            </select>
        </div>
    </div>
</div>

@foreach ($tasks as $task)
{{-- <div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}"> --}}
    <label hidden for="files" class="col-md-3 control-label">
        {{ trans('admin/tasks/form.start_date') }}
    </label>
    {{-- <div class="col-md-8 col-sm-12"> --}}
        <label hidden for="files" class="col-md-5 control-label">
            {{ \App\Helpers\Helper::getFormattedDateObject($task->contract_start_date, 'date', false) }}
        </label>
    {{-- </div> --}}
{{-- </div> --}}
@endforeach  

<!--  contract start date   -->
<div class="form-group {{ $errors->has('contract_start_date') ? ' has-error' : '' }}">
    <label for="contract_start_date" class="col-md-3 control-label">{{trans('admin/subtasks/form.start_date') }}</label>
    <div class="input-group col-md-4{{  (\App\Helpers\Helper::checkIfRequired($item, 'name')) ? ' required' : '' }}">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="contract_start_date" id="dob1" value="{{ old('contract_start_date', ($item->contract_start_date) ? $item->contract_start_date->format('Y-m-d') : '') }}" required onchange="findDiff();">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
             <div class="col-sm-offset-1 col-md-7">
                @include ('partials.more-info', ['helpText' => "Please ensure that the End Date is greater than or equal to the $task->contract_start_date.", 'helpPosition' => 'right'])
             </div>
        </div>
        {!! $errors->first('contract_start_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>

@foreach ($tasks as $task)
<input type="hidden" class="form-control" placeholder="{{ trans('admin/subtasks/form.start_date')}}"  name="contract_end_date" id="dob3" value="{{$task->contract_end_date}}">
    {{-- <div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}"> --}}
        <label hidden for="files" class="col-md-3 control-label">
            {{ trans('admin/tasks/form.end_date') }}
        </label>
        {{-- <div class="col-md-7 col-sm-12"> --}}
            <label hidden for="files" class="col-md-3 control-label">
                {{ \App\Helpers\Helper::getFormattedDateObject($task->contract_end_date, 'date', false) }}
            </label>
        {{-- </div> --}}
    {{-- </div> --}}
@endforeach  

 <!-- contract end date  -->
 <div class="form-group {{ $errors->has('contract_end_date') ? ' has-error' : '' }}">
    <label for="contract_end_date" class="col-md-3 control-label">{{trans('admin/subtasks/form.end_date') }}</label>
    <div class="input-group col-md-4{{  (\App\Helpers\Helper::checkIfRequired($item, 'name')) ? ' required' : '' }}">
                  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}"  name="contract_end_date" id="dob2" value="{{ old('contract_end_date', ($item->contract_end_date) ? $item->contract_end_date->format('Y-m-d') : '') }}" required onchange="findDiff();">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
             <div class="col-sm-offset-1 col-md-7">
                @include ('partials.more-info', ['helpText' => "Please ensure that the End Date is greater than or equal to the $task->contract_end_date.", 'helpPosition' => 'right'])
            </div>
            
        </div>
         {{-- <div>
             <br>
             <button type="button"  onclick="findDiff();" class="btn btn-warning">Comfirm The Date</button>
             </div> --}}
             
        {!! $errors->first('contract_end_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>

 <!-- contract duration day -->

 <div class="form-group {{ $errors->has('contract_duration') ? ' has-error' : '' }}">
    <label for="contract_duration" class="col-md-3 control-label">{{ trans('admin/subtasks/form.duration') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left:0px">
          <input class="form-control" type="text" name="contract_duration" id="days" value="{{ Request::old('contract_duration', $item->contract_duration) }}"  readonly  />
            <span class="input-group-addon">
                Days
            </span>
        </div>
    </div>
    {!! $errors->first('contract_duration', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>

 <!-- actual start date   -->
<div class="form-group {{ $errors->has('actual_start_date') ? ' has-error' : '' }}">
    <label for="actual_start_date" class="col-md-3 control-label">{{ trans('general.actual_start_date') }}</label>
    <div class="input-group col-md-3">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                   <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="actual_start_date" id="actual_start_date" value="{{ old('actual_start_date', ($item->actual_start_date) ? $item->actual_start_date->format('Y-m-d') : '') }}" onchange="findDiffactual();">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('actual_start_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>
 
 <!-- actual end date  -->
 <div class="form-group {{ $errors->has('actual_end_date') ? ' has-error' : '' }}">
    <label for="actual_end_date" class="col-md-3 control-label">{{ trans('general.actual_end_date') }}</label>
    <div class="input-group col-md-3">
                  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}"  name="actual_end_date" id="actual_end_date" value="{{ old('actual_end_date', ($item->actual_end_date) ? $item->actual_end_date->format('Y-m-d') : '') }}" onchange="findDiffactual();">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>  
        {{-- <div>
            <br>
                  <button type="button"  onchange="findDiffactual();" class="btn btn-warning">Comfirm The Date</button>
                </div> --}}
        {!! $errors->first('actual_end_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>
 
 <div class="form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
    <label for="duration" class="col-md-3 control-label">{{ trans('admin/subtasks/form.duration') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left:0px">
                    <input class="form-control" type="text" name="actual_duration" id="actual_days" value="{{ Request::old('duration', $item->duration) }}" readonly />
                        <span class="input-group-addon">
                            Days
                        </span>
        </div>
    </div>
    {!! $errors->first('duration', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
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
<script>

    function findDiff(){
    var dob1= document.getElementById("dob1").value;
    var dob2= document.getElementById("dob2").value;
    var dob3= document.getElementById("dob3").value;
    var date1 = new Date(dob1);
    var date2=new Date(dob2);
    var date3=new Date(dob3);
    
    
    if(dob1!= '' && dob2!= '' && date2> date3)
        {
            
        alert("Please ensure that the End Date is greater than or equal to the implmentation plan date end.");
        return false; 
        }

    if(dob1!= '' && dob2!= '' && date1> date2)
        {
            
        alert("Please ensure that the End Date is greater than or equal to the Start Date.");
        return false; 
        }
        
    var ONE_DAY = 1000 * 60 * 60 * 24
    var d1 = date1.getTime()
    var d2 = date2.getTime()
    var diff = Math.abs(d1 - d2)
    document.getElementById("days").value=Math.round(diff/ONE_DAY + 1 );
    }
    
    function findDiffactual(){
    var dob1= document.getElementById("actual_start_date").value;
    var dob2= document.getElementById("actual_end_date").value;
    var date1 = new Date(dob1);
    var date2=new Date(dob2);
    
    
    if(dob1!= '' && dob2!= '' && date1> date2)
        {
            
        alert("Please ensure that the End Date is greater than or equal to the Start Date.");
        return false; 
        }
        
    var ONE_DAY = 1000 * 60 * 60 * 24
    var d1 = date1.getTime()
    var d2 = date2.getTime()
    var diff = Math.abs(d1 - d2)
    document.getElementById("actual_days").value=Math.round(diff/ONE_DAY + 1  );
    }

    </script> 
@stop
