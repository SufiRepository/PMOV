@extends('layouts/default')

{{-- Page title --}}
@section('title')
Update Issue
@parent
@stop

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ URL::previous() }}" class="btn btn-primary">
    {{ trans('general.back') }}</a>
</div>
@stop

@section('content')

{{-- Page content --}}
{{-- @section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/helpdesks/table.name')])

@if (\App\Models\Company::canManageUsersCompanies())
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@endif --}}

<!-- row -->
<div class="row">
    <!-- col-md-8 -->
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

        <!-- box -->
        <div class="box box-default">

            <!-- box-header -->
            <div class="box-header with-border text-right">

                <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                    <div class="col-md-12" style="padding: 0px; margin: 0px;">
                        {{-- <div class="col-md-9 text-left">
                            @if ($item->id)
                                <h2 class="box-title text-left" style="padding-top: 8px;">
                                    {{ $item->display_name }}
                                </h2>
                            @endif
                        </div>
                        <div class="col-md-3 text-right" style="padding-right: 10px;">
                            <a class="btn btn-link text-left" href="">
                                {{ trans('button.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check icon-white" aria-hidden="true"></i>
                                {{ trans('general.save') }}
                            </button>
                        </div> --}}
                    </div>
                </div>
                @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
                @endif
            </div><!-- /.box-header -->

            <!-- box-body -->
            <div class="box-body">


                <form id="create-form" class="form-horizontal" action="{{ route('helpdeskcreatetaskload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  
                     <div class="row">

                        {{-- Client --}}
                        <div class="form-group">
                          <label for="name" class="col-md-3 control-label">Issue</label>
                          <div class="col-md-7 col-sm-12">
                              {{-- <input class="form-control" type="text" name="client" aria-label="client" id="client" value="" /> --}}
                              <p class="form-control"><b>{{$helpdesk->name}}</b></p>

                          </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                            <label class="col-md-3 control-label">Select Task:</label>
                            <div class="col-md-9">
                                <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                    <select class="form-control" name="task_name" style="width: 100%">
                                        @foreach ($tasks as $task)
                                            <option name="task_name" value="{{ $task->name }}"> 
                                                {{ $task->name }} 
                                            </option>
                                        @endforeach    
                                    </select>
                                </div>
                                
                            </div>
                        </div>  

                        {{-- Client --}}
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Client</label>
                            <div class="col-md-7 col-sm-12">
                                {{-- <input class="form-control" type="text" name="client" aria-label="client" id="client" value="" /> --}}
                                <p class="form-control"><b>{{$helpdesk->client_name}}</b></p>
  
                            </div>
                          </div>

                        {{-- Client Phone --}}
                        <div class="form-group">
                          <label for="name" class="col-md-3 control-label">Phone</label>
                          <div class="col-md-7 col-sm-12">
                              {{-- <input class="form-control" type="number" name="phone" aria-label="phone" id="phone" value="" /> --}}
                              <p class="form-control"><b>{{$helpdesk->client_phone}}</b></p>
                          </div>
                        </div>

                        {{-- Client Email --}}
                        <div class="form-group">
                          <label for="name" class="col-md-3 control-label">Email</label>
                          <div class="col-md-7 col-sm-12">
                            <p class="form-control"><b>{{$helpdesk->client_email}}</b></p>
                              {{-- <input class="form-control" type="text" name="email" aria-label="email" id="email" value="" /> --}}
                          </div>
                        </div>

                        {{-- Client Address --}}
                        <div class="form-group">
                          <label for="name" class="col-md-3 control-label">Address</label>
                          <div class="col-md-7 col-sm-12">
                            <p class="form-control"><b>{{$helpdesk->client_address}}</b></p>
                              {{-- <input class="form-control" type="text" name="address" aria-label="address" id="address" value="" /> --}}
                          </div>
                        </div>

                        {{-- project id  --}}
                        {{-- <input type="hidden" name="project_id" value="{{ $project->id }}"> --}}

                        {{-- @foreach ($projectid as $project)
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        @endforeach   --}}

                        {{-- @include ('partials.forms.edit.notes') --}}

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                          <label class="col-md-3 control-label">Priority:</label>
                              <div class="col-md-9">
                                  <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                      {{-- <select class="form-control" name="priority" style="width: 100%">
                                          <option value="High" selected>High</option>
                                          <option value="Medium">Medium</option>
                                          <option value="Low">Low</option>  
                                      </select> --}}
                                      <p class="form-control"><b>{{$helpdesk->priority}}</b></p>
                                  </div>
                              </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                          <label class="col-md-3 control-label">Status:</label>
                              <div class="col-md-9">
                                  <div class="input-group col-md-7 col-sm-12" style="padding-left: 0px;">
                                      {{-- <select class="form-control" name="status" style="width: 100%">
                                          <option value="Open" selected>Open</option>
                                          <option value="Pending">Pending</option>
                                          <option value="On Hold">On Hold</option>  
                                          <option value="Resolved">Resolved</option>
                                          <option value="Closed<">Closed</option>  
                                      </select> --}}
                                      <p class="form-control"><b>{{$helpdesk->status}}</b></p>
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
                              <input class="form-control" type="text" name="solution" aria-label="solution" id="solution" value="" />
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

                        <div class="form-group {{ $errors->has('files') ? ' has-error' : '' }}">
                            <label for="files" class="col-md-3 control-label">Select Files</label>
                            <div class="col-md-7 col-sm-12">
                                <input type="file" name="file" class="custom-file-input" id="chooseFile">    
                                <p >only csv,txt,xlx,xls,pdf type file, and 5Mb</p>
                        
                            </div>
                        
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

            
                    </div>
                   
                </form>

            </div> <!-- ./box-body -->


        </div><!-- box -->
        
    </div> <!-- col-md-8 -->

</div><!-- ./row -->

@stop

