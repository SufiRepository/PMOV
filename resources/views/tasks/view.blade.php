@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{-- {{ trans('admin/tasks/general.view') }}--}}
{{$task->name}} 

@parent
@stop

@section('header_right')

<a href="{{ route('projectsreroute',['projectid'=> $task->project_id]) }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>

  @can('update', $task)
  <a   type="button" class="btn btn-primary pull-right "  href="{{ route('tasks.edit', ['task' => $task->id]) }}">
     <i class="fa fa-pencil-square" aria-hidden="true"></i>{{ trans('admin/tasks/general.edit') }}</a>
   @endcan


  {{-- <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
  </button>

    <ul class="dropdown-menu" role="menu">
      <li role="menuitem"><a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ trans('admin/tasks/general.edit') }}</a></li>
      <li role="menuitem">  <a   href="{{route('testsubtask', $task->id)}}">{{ trans('admin/subtasks/general.create_task') }}</a> </li>
    </ul> --}}

@stop


{{-- Page content --}}
@section('content')

  {{-- <div class="row"> --}}
  {{--  view total contractor on project --}}
    {{-- <div class="col-lg-2 col-xs-3"> --}}
  <!-- small box -->
    {{-- <a href="#subtasks" data-toggle="tab"> --}}
        {{-- <div class="small-box bg-purple"> --}}
            {{-- <div class="inner"> --}}
             {{-- <p>{{ trans('general.tasks') }}</p> --}}
            {{-- </div> --}}
             {{-- <a  href="{{route('testsubtask', $task->id)}}" class="btn btn-danger btn-sm btn-block">{{ trans('admin/subtasks/general.create_task') }} </a> --}}
        {{-- </div> --}}
    {{-- </div><!-- ./col --> --}}


      {{-- added by fikri --}}
    {{-- <div class="col-lg-2 col-xs-3"> --}}
    <!-- small box -->
      {{-- <a href="#uploadedfile" data-toggle="tab"> --}}
      {{-- <div class="small-box bg-orange"> --}}
          {{-- <div class="inner"> --}}
            {{-- <p>Upload File</p> --}}
          {{-- </div> --}}
            {{-- @can('create', \App\Models\TaskFile::class) --}}
              {{-- <a href="{{ route('taskuploads.create',['id' => $task->id]) }}" class="btn btn-danger btn-sm btn-block">{{ trans('general.create') }}</a> --}}
            {{-- @endcan --}}
      {{-- </div> --}}
    {{-- </div><!-- ./col --> --}}
  {{-- </div> --}}


  <div class="row">
    <div class="col-md-9">
      {{-- <div class="row">
        <div class="col-md-9"> --}}
    
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
              <li><a href="#uploadedfile" data-toggle="tab">Upload Files</a></li>
              <li class=""><a href="#subtasks" data-toggle="tab">{{ trans('admin/subtasks/form.subtasks') }}</a></li>
              {{-- <li><a href="#billings" data-toggle="tab">billings</a></li> --}}
            </ul>
          
            <div class="tab-content">
          
              <div class="tab-pane active" id="details">
                <div class="row">
                  <div class="col-md-12">
                    <div class="container row-striped">

                      @if ($task->name)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.name') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->name)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->milestone)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.milestones') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->milestone)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->amount_task)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.amount') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            RM {!! nl2br(e($task->amount_task)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->billingOrpayment)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.billingpayment') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->billingOrpayment)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->payment_schedule_date)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.billingschedule') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->payment_schedule_date)) !!}
                            {{-- {{ \App\Helpers\Helper::getFormattedDateObject($task->payment_schedule_date, 'date', false) }} --}}
                            
                          </div>
                        </div>
                      @endif

                      @if ($task->contractor_id)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.contractor') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->contractor->name)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->supplier_id)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.supplier') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->supplier->name)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->team_member)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.team_member') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($user->first_name)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->priority)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.priority') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->priority)) !!}
                          </div>
                        </div>
                      @endif

                      @if ($task->statustask_id)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.status') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->statustask_id)) !!}
                          </div>
                        </div>
                      @endif
                      
                      @if ($task->contract_start_date)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.start') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {{-- {!! nl2br(e($task->contract_start_date)) !!} --}}
                            {{ \App\Helpers\Helper::getFormattedDateObject($task->contract_start_date, 'date', false) }}
                          </div>
                        </div>
                      @endif

                      @if ($task->contract_end_date)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.end') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {{-- {!! nl2br(e($task->contract_end_date)) !!} --}}
                            {{ \App\Helpers\Helper::getFormattedDateObject($task->contract_end_date, 'date', false) }}
                          </div>
                        </div>
                      @endif

                      @if ($task->contract_duration)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.duration') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->contract_duration)) !!} Days
                          </div>
                        </div>
                      @endif

                      @if ($task->actual_start_date)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.actual_start_date') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {{-- {!! nl2br(e($task->actual_start_date)) !!} --}}
                            {{ \App\Helpers\Helper::getFormattedDateObject($task->actual_start_date, 'date', false) }}
                          </div>
                        </div>
                      @endif

                      @if ($task->actual_end_date)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.actual_end_date') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {{ \App\Helpers\Helper::getFormattedDateObject($task->actual_end_date, 'date', false) }}
                          </div>
                        </div>
                      @endif

                      @if ($task->actual_duration)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.actual_duration') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->actual_duration)) !!} Days
                          </div>
                        </div>
                      @endif

                      @if ($task->details)
                        <div class="row">
                          <div class="col-md-4">
                            <strong>
                              {{ trans('general.details') }}
                            </strong>
                          </div>
                          <div class="col-md-8">
                            {!! nl2br(e($task->details)) !!}
                          </div>
                        </div>
                      @endif
                  </div>
                </div>
          
                </div> <!--/.row-->
              </div> <!-- /.tab-pane -->
              <div class="tab-pane" id="subtasks">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-header with-border">
                      <div class="box-heading">
                        <h2 class="box-title"> {{ trans('List of Subtask') }}</h2>
                      </div>
                    </div><!-- /.box-header -->    
                    <div class="box">
                      <div class="box-body">
        
                        <table
                          data-columns="{{ \App\Presenters\SubtaskPresenter::dataTableLayout() }}"
                          data-cookie-id-table="subtaskTable"
                          data-pagination="true"
                          data-search="true"
                          data-side-pagination="server"
                          data-show-columns="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          data-sort-name="name"
                          id="subtaskTable"
                          class="table table-striped snipe-table"
                          data-url="{{ route('api.subtasks.index',['task_id' => $task->id]) }}"
                          data-export-options='{
                          "fileName": "export-projects-{{ date('Y-m-d') }}",
                          "ignoreColumn": ["actions","image","change","icon"]}'>
                        </table>
                      </div><!-- /.box-body -->
                      <div class="box-footer clearfix">
                      </div>
                    </div><!-- /.box -->
                  </div>
                </div>
              </div>
        
              <div class="tab-pane" id="uploadedfile">
                <div class="row">
                  <div class="col-md-12">
                
                      <div class="box-header with-border">
                        <div class="box-heading">
                          <h2 class="box-title"> {{ trans('general.listoffiles') }}</h2>
                        </div>
                      </div><!-- /.box-header -->    
                      <div class="box">
                      <div class="box-body">
                        <table
                        data-columns="{{ \App\Presenters\TaskFilePresenter::dataTableLayout() }}"
                        data-cookie-id-table="taskFileTable"
                        data-pagination="true"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-footer="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        id="taskFileTable"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.taskuploads.index',['task_id' => $task->id]) }}"
                        data-export-options='{
                      "fileName": "export-taskfiles-{{ date('Y-m-d') }}",
                      "ignoreColumn": ["actions","image","change","icon"]
                      }'>
                  </table>
                
                      </div><!-- /.box-body -->
                
                      <div class="box-footer clearfix">
                      </div>
                    </div><!-- /.box -->
                  </div>
          
                </div> <!--/.row-->
              </div> <!-- /.tab-pane -->
          
          
              <div class="tab-pane" id="billings">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-body">
                
                        <table
                        data-columns="{{ \App\Presenters\BillingPresenter::dataTableLayout() }}"
                        data-cookie-id-table="billingTable"
                        data-pagination="true"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-footer="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        id="billingTable"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.billings.index',['task_id' => $task->id]) }}"
                        data-export-options='{
                      "fileName": "export-projects-{{ date('Y-m-d') }}",
                      "ignoreColumn": ["actions","image","change","icon"]
                      }'>
                       </table>
                
                      </div><!-- /.box-body -->
                
                      <div class="box-footer clearfix">
                      </div>
                    </div><!-- /.box -->
                  </div>
          
                </div> <!--/.row-->
              </div> <!-- /.tab-pane -->
          
              <div class="tab-pane" id="billings">
                <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                      <div class="box-body">
                
                        <table
                        data-columns="{{ \App\Presenters\BillingPresenter::dataTableLayout() }}"
                        data-cookie-id-table="billingTable"
                        data-pagination="true"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-footer="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        id="billingTable"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.billings.index',['task_id' => $task->id]) }}"
                        data-export-options='{
                      "fileName": "export-projects-{{ date('Y-m-d') }}",
                      "ignoreColumn": ["actions","image","change","icon"]
                      }'>
                       </table>
                
                      </div><!-- /.box-body -->
                
                      <div class="box-footer clearfix">
                      </div>
                    </div><!-- /.box -->
                  </div>
          
                </div> <!--/.row-->
              </div> <!-- /.tab-pane -->
          
          </div>
          </div>
    
        </div>
    
        <div class="col-md-3">
    
          
        {{-- </div>
    
      </div> --}}

    </div>

    <div class="col-md-3">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"> Task Details </h3>
        </div>
        <div class="panel-body">

            @if (!is_null($task->statustask) && ($task->statustask->id == 3))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.statustask') }}</strong>
              </div>
              <div class="col-md-8">
                {{ $task->statustask->name }}
              </div>
            </div>
            @endif

    @if (!is_null($task->statustask) && ($task->statustask->id == 1))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.statustask') }}</strong>
        </div>
        <div class="col-md-8">
          
          {{ $task->statustask->name }}
        </div>
      </div>
    @endif

    @if (!is_null($task->statustask) && ($task->statustask->id == 4))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.statustask') }}</strong>
        </div>
        <div class="col-md-8">
          
          <button type="button" class="btn btn-danger">{{ $task->statustask->name }}</button>

          <br>
          
        </div>
      </div>
    @endif

    @if (!is_null($task->statustask) && ($task->statustask->id == 5))
    <div class="row">
      <div class="col-md-4">
        <strong>{{ trans('general.statustask') }}</strong>
      </div>
      <div class="col-md-8">
        {{ $task->statustask->name }}
      </div>
    </div>
  @endif

       @if ($task->priority)
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('admin/tasks/form.priority')}}
            </strong>
          </div>
          <div class="col-md-8">
            {!! nl2br(e($task->priority)) !!}
          </div>
        </div>
        @endif     
     
      
  @if (!is_null($task->payment))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.payment') }}</strong>
        </div>
        <div class="col-md-8">
          {!! nl2br(e($task->payment)) !!}
        </div>
      </div>
    @endif
      
    @if (!is_null($task->team))
    <div class="row">
      <div class="col-md-4">
        <strong>{{ trans('general.persone_inchrage') }}</strong>
      </div>
      <div class="col-md-8">
        
        {!! nl2br(e($task->manager_id)) !!}

      </div>
    </div>
  @endif

  @if (!is_null($task->team_member))
  <div class="row">
    <div class="col-md-4">
      <strong>{{ trans('general.team_member') }}</strong>
    </div>
    <div class="col-md-8">
      
      {!! nl2br(e($task->team_member)) !!}

    </div>
  </div>
@endif


      @if (!is_null($task->contractor))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.contractors') }}</strong>
        </div>
        <div class="col-md-8">
          <a href="{{ url('/contractors/' . $task->contractor->id) }}"> {{ $task->contractor->name }} </a>
        </div>
      </div>
    @endif

    @if (!is_null($task->supplier))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.supplier') }}</strong>
        </div>
        <div class="col-md-8">
          <a href="{{ url('/suppliers/' . $task->supplier->name) }}"> {{ $task->supplier->name}}</a>
        </div>
      </div>
    @endif

      @if ($task->contract_start_date)
        <div class="row">
          <div class="col-md-4">
            <strong>
              
              {{ trans('admin/tasks/form.start_date')}}
            </strong>
          </div>
          <div class="col-md-8">
            {{ \App\Helpers\Helper::getFormattedDateObject($task->contract_start_date, 'date', false) }}
          </div>
        </div>
      @endif
      
      @if (isset($task->contract_end_date))
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('admin/tasks/form.end_date')}}
          </strong>
        </div>
        <div class="col-md-8">
          {{ \App\Helpers\Helper::getFormattedDateObject($task->contract_end_date, 'date', false) }}
        </div>
      </div>
      @endif
  

      @if ($task->contract_duration)
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('Duration') }}
          </strong>
        </div>
        <div class="col-md-8">
          {!! nl2br(e($task->contract_duration)) !!} Days
        </div>
      </div>
      @endif

      @if ($task->actual_start_date)
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('general.actual_start_date') }}
            </strong>
          </div>
          <div class="col-md-8">
            {{ \App\Helpers\Helper::getFormattedDateObject($task->actual_start_date, 'date', false) }}
          </div>
        </div>
      @endif
      
      @if (isset($task->actual_end_date))
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('general.actual_end_date') }}
          </strong>
        </div>
        <div class="col-md-8">
          {{ \App\Helpers\Helper::getFormattedDateObject($task->actual_end_date, 'date', false) }}
        </div>
      </div>
      @endif

      @if ($task->actual_duration)
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('general.actual_duration') }}
          </strong>
        </div>
        <div class="col-md-8">
          {!! nl2br(e($task->actual_duration)) !!}
        </div>
      </div>
      @endif

        @if ($task->details)
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('general.details') }}
            </strong>
          </div>
          <div class="col-md-8">
            {!! nl2br(e($task->details)) !!}
          </div>
        </div>
        @endif     
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"> Task Actions</h3>
        </div>
        <div class="panel-body">
          <div>
            @can('create', \App\Models\Subtask::class)
             <a  href="{{route('testsubtask', $task->id)}}" class="btn btn-primary btn-sm ">  <i class="fa fa-university" aria-hidden="true"></i>{{ trans('admin/subtasks/general.create_subtask') }} </a>
            @endcan
          </div>
          <br>
        <div>
            @can('create', \App\Models\TaskFile::class) 
              <a href="{{ route('taskuploads.create',['id' => $task->id]) }}" class="btn btn-primary btn-sm "> <i class="fa fa-upload" aria-hidden="true"></i>
                {{ trans('general.upload_file') }}</a>
            @endcan

        </div>
       </div>
      </div>
    </div>
  </div>


@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'task' . $task->name . '-export', 'search' => false])
@stop