@extends('layouts/edit-form', [
    'createText' => trans('Create Milestone') ,
    'updateText' => trans('Update Tasks'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.tasks'),
    'formAction' => (isset($item->id)) ? route('tasks.update', ['task' => $item->id]) : route('tasks.store'),
])
{{-- Page content --}}
@section('inputFields')


{{-- @include ('partials.forms.edit.start_date')
@include ('partials.forms.edit.due_date') --}}
{{-- project id  --}}
 <!-- Manager -->
 {{-- @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id']) --}}
 

 @include ('partials.forms.edit.name', ['translated_name' => trans('Tasks')])

 @include ('partials.forms.edit.contractor-select', ['translated_name' => trans('general.contractors'), 'fieldname' => 'contractor_id'])
 @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

 <div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">Priority:</label>
        <div class="col-md-9">
            <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                <select class="form-control" name="priority" style="width: 100%">
                    <option >  </option>
                    <option value="High" selected>High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>  
                </select>
            </div>
        </div>
</div>

 <div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label class="col-md-3 control-label"> Status:</label>
    <div class="col-md-9">
        <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
            <select class="form-control" name="statustask_id" style="width: 100%">
                <option >  </option>
                <option name="1" value="Completed"> Completed </option>
                <option name="1" value="Ongoing"> Ongoing </option>
                <option name="1" value="Delayed">Delayed</option>
                <option name="1" value="Upcoming">Upcoming  </option>
            </select>
        </div>
    </div>
</div> 

<!--  contract start date   -->


<div class="form-group {{ $errors->has('contract_start_date') ? ' has-error' : '' }}">
    <label for="contract_start_date" class="col-md-3 control-label">  {{ trans('Start') }}</label>
    <div class="input-group col-md-3">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
              {{-- <div>  --}}
                   <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="contract_start_date" id="dob1" value="{{ old('contract_start_date', ($item->contract_start_date) ? $item->contract_start_date->format('Y-m-d') : '') }}" required  onchange="findDiff();">

             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('contract_start_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>


 <!-- contract end date  -->
 <div class="form-group {{ $errors->has('contract_end_date') ? ' has-error' : '' }}">
    <label for="contract_end_date" class="col-md-3 control-label"> {{ trans('End') }}</label>
    <div class="input-group col-md-3">
              {{-- <div>   --}}
                  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}"  name="contract_end_date" id="dob2" value="{{ old('contract_end_date', ($item->contract_end_date) ? $item->contract_end_date->format('Y-m-d') : '') }}" required  onchange="findDiff();">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            
        </div>
         {{-- <div>
             <br>
             <button type="button"  onchange="findDiff();" class="btn btn-warning">Comfirm The Date</button>
             </div> --}}
        {!! $errors->first('contract_end_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>

 <!-- contract duration day -->

 <div class="form-group {{ $errors->has('contacrt_duration') ? ' has-error' : '' }}">
    <label for="contract_duration" class="col-md-3 control-label">{{ 'Duration' }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left:0px">
          <input class="form-control" type="text" name="contract_duration" id="days" value="{{ Request::old('contract_duration', $item->contract_duration) }}" readonly />
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
    <label for="duration" class="col-md-3 control-label">{{ 'Duration' }}</label>
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
{{-- end add --}}
@stop