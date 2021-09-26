@extends('layouts/edit-form', [
    'createText' => trans('admin/projects/form.create'),
    'updateText' => trans('admin/projects/form.update'),
    'topSubmit' => true,
    'helpPosition'  => 'right',
    'helpText' => trans('admin/projects/table.help'),
    'formAction' => ($item->id) ? route('projects.update', ['project' => $item->id]) : route('projects.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/projects/form.name'), 'required' => 'true'])

@include ('partials.forms.edit.projectnumber', ['translated_projectnumber' => trans('admin/projects/form.projectnumber')])

{{-- <!-- Project Plan -->
<div class="form-group {{ $errors->has('implementationplan') ? ' has-error' : '' }}">
    <label for="implementationplan" class="col-md-3 control-label">{{ trans('general.projectplan') }}</label>
    <div class="col-md-7 col-sm-12">
        <div class="col-md-12" style="padding-left:0px">
            <input class="form-control" type="text" name="projectnumber" id="implementationplan" value="{{ Request::old('implementationplan', $item->implementationplan->name) }}" />
        </div>
    </div>
    {!! $errors->first('implementationplan', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div> --}}


{{-- @include ('partials.forms.edit.status') --}}

@if (\App\Models\Company::canManageUsersCompanies())
    @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif
<!-- Location -->
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
{{-- @include ('partials.forms.edit.new-location') --}}
{{-- client register --}}
@include ('partials.forms.edit.client-select', ['translated_name' => trans('general.client'), 'fieldname' => 'client_id'])

{{-- @include ('partials.forms.edit.typeproject-select', ['translated_name' => trans('general.typeproject')]) --}}


{{-- <div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">Project Type:</label>
    <div class="col-md-9">
        <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
            <select class="form-control" name="typeproject_id" style="width: 100%">
                @foreach ($typeprojects as $typeproject)
                    <option  value="{{ $typeproject->id }}"> 
                        {{ $typeproject->name }} 
                    </option>
                @endforeach    
            </select>
        </div>
    </div>
</div> --}}

@include ('partials.forms.edit.value2')


{{-- @include ('partials.forms.edit.start_date')

@include ('partials.forms.edit.due_date')

 @include ('partials.forms.edit.duration') --}}


@include ('partials.forms.edit.details')


{{-- <body>
    <pre>
  Enter Date1(yyyy-mm-dd): <input type="date" name="dob1" id="dob1" />
Enter Date2(yyyy-mm-dd): <input type="date" name="dob2" id="dob2" />
Number of days: <input type="text" name="days" id="days" />
<input type="button" value="calculate" onclick="findDiff();">
    
    </pre>
    </body>

     --}}

     <div class="form-group {{ $errors->has('gps') ? ' has-error' : '' }}">
        <label for="gps" class="col-md-3 control-label"> {{ trans('general.start_date') }}</label>
        <div class="col-md-8 col-sm-13">
            <div class="col-xs-3">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true"   >
                              <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="start_date" id="dob1" value="{{ old('start_date', ($item->start_date) ? $item->start_date->format('Y-m-d') : '') }}" required onchange="findDiff();">
                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                   </div>
                   {!! $errors->first('start_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>


      <div class="col-xs-5">
        <label for="due_date" class="col-md-6 control-label">{{ trans('general.end_date') }}</label>

        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true" >
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}"  name="end_date" id="dob2" value="{{ old('end_date', ($item->end_date) ? $item->end_date->format('Y-m-d') : '') }}" required onchange="findDiff();">
                <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
    {!! $errors->first('due_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}    
            </div>
        </div>
    </div>

    

{{-- <!-- start date  -->
<div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
    <label for="start_date" class="col-md-3 control-label">{{ trans('general.start_date') }}</label>
    <div class="input-group col-md-3">
         <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true"   >
                   <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="start_date" id="dob1" value="{{ old('start_date', ($item->start_date) ? $item->start_date->format('Y-m-d') : '') }}" required onchange="findDiff();">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('start_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div>
 
 

 <!-- due date  -->
<div class="form-group {{ $errors->has('due_date') ? ' has-error' : '' }}">
    <label for="due_date" class="col-md-3 control-label">{{ trans('general.end_date') }}</label>
    <div class="input-group col-md-3">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true" >
                <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}"  name="end_date" id="dob2" value="{{ old('end_date', ($item->end_date) ? $item->end_date->format('Y-m-d') : '') }}" required onchange="findDiff();">
                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
            </div>
      
        {!! $errors->first('due_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
 </div> --}}
 
<!-- duration date  -->

    <div class="form-group {{ $errors->has('duration') ? ' has-error' : '' }}">
        <label for="duration" class="col-md-3 control-label">{{ 'Duration' }}</label>
        <div class="col-md-9">
            <div class="input-group col-md-4" style="padding-left:0px">
                <input class="form-control" type="text" name="duration" id="days" value="{{ Request::old('duration', $item->duration) }}"  readonly/>
                    <span class="input-group-addon">
                        Days
                    </span>
            </div>
        </div>
    {!! $errors->first('duration', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
</div>

<script>



function findDiff(){
var dob1= document.getElementById("dob1").value;
var dob2= document.getElementById("dob2").value;
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
document.getElementById("days").value=Math.round(diff/ONE_DAY + 1  );
}

</script>




@stop
