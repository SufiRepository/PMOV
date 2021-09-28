@extends('layouts/edit-form', [
    'createText' => trans('admin/helpdesks/table.create') ,
    'updateText' => trans('admin/helpdesks/table.update'),
    'helpTitle' => trans('admin/helpdesks/table.about_helpdesks_title'),
    'helpText' => trans('admin/helpdesks/table.about_helpdesks_text'),
    'formAction' => (isset($item->id)) ? route('helpdesks.update', ['helpdesk' => $item->id]) : route('helpdesks.store'),
])


{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/helpdesks/table.name')])

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif

{{-- Client --}}
<div class="form-group">
    <label for="name" class="col-md-3 control-label">Client</label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="text" name="client" aria-label="client" id="client" value="" />
    </div>
</div>

{{-- Client Phone --}}
<div class="form-group">
    <label for="name" class="col-md-3 control-label">Phone</label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="number" name="phone" aria-label="phone" id="phone" value="" />
    </div>
</div>

{{-- Client Email --}}
<div class="form-group">
    <label for="name" class="col-md-3 control-label">Email</label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="text" name="email" aria-label="email" id="email" value="" />
    </div>
</div>

{{-- Client Address --}}
<div class="form-group">
    <label for="name" class="col-md-3 control-label">Address</label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="text" name="address" aria-label="address" id="address" value="" />
    </div>
</div>

{{-- project id  --}}
{{-- <input type="hidden" name="project_id" value="{{ $project->id }}"> --}}

@foreach ($projectid as $project)
<input type="hidden" name="project_id" value="{{ $project->id }}">

 @endforeach  

{{-- @include ('partials.forms.edit.notes') --}}
 
<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label class="col-md-3 control-label">Priority:</label>
        <div class="col-md-9">
            <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                <select class="form-control" name="priority" style="width: 100%">
                    <option value="High" selected>High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>  
                </select>
            </div>
        </div>
</div>

<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label class="col-md-3 control-label">Status:</label>
        <div class="col-md-9">
            <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                <select class="form-control" name="status" style="width: 100%">
                    <option value="Open" selected>Open</option>
                    <option value="Pending">Pending</option>
                    <option value="On Hold">On Hold</option>  
                    <option value="Resolved">Resolved</option>
                    <option value="Closed<">Closed</option>  
                </select>
            </div>
        </div>
</div>

<div class="form-group">
    <label for="due_date" class="col-md-3 control-label">Due date</label>
    <div class="input-group col-md-3">
                  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
             <input type="text" class="form-control" placeholder="Select date"  name="due_date" id="due_date" value="">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>  
    </div>
 </div>

 <!-- details -->
 <div class="form-group">
    <label class="col-md-3 control-label">Description</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="description" aria-label="description" name="description"></textarea>
    </div>
</div>

<hr>

{{-- Client Engineer --}}
<div class="form-group">
    <label for="name" class="col-md-3 control-label">Engineer</label>
    <div class="col-md-7 col-sm-12">
        <input class="form-control" type="text" name="engineer" aria-label="engineer" id="engineer" value="" />
    </div>
</div>

{{-- Client Solution --}}
<div class="form-group">
    <label for="name" class="col-md-3 control-label">Solution</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="solution" aria-label="solution" name="solution"></textarea>

        {{-- <input class="form-control" type="text" name="solution" aria-label="solution" id="solution" value="" /> --}}
    </div>
</div>

<div class="form-group col-xs-12 col-sm-12 col-md-12">
    <label for="costing" class="col-md-3 control-label">Status:</label>
        <div class="col-md-9">
            <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                <select class="form-control" name="priority" style="width: 100%">
                    <option value="Open" selected>Open</option>
                    <option value="Pending">Pending</option>
                    <option value="On Hold">On Hold</option>  
                    <option value="Resolved">Resolved</option>
                    <option value="Closed<">Closed</option>  
                </select>
            </div>
        </div>
</div>

<div class="form-group">
    <label for="due_date" class="col-md-3 control-label">Responded date</label>
    <div class="input-group col-md-3">
        <div class="input-group"  data-autoclose="true">
             <input type="datetime-local" class="form-control" placeholder="dd-mm-yyyy" 
              name="responded_date" id="responded_date" value=""
              min="1997-01-01" max="2030-12-31">
             <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>

        </div>  
    </div>
 </div>

@stop

