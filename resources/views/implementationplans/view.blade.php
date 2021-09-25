@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{-- <div class="p-3 mb-2 bg-success text-white">{{$implementationplan->name}}</div> --}}
  {{$implementationplan->name}} 
{{-- {{ trans('admin/implementationplans/form.end_date_project') }} :  {{$implementationplan->start_date}}   --}}


@parent
@stop

@section('header_right')

<a href="{{ route('projectsreroute',['projectid'=> $implementationplan->project_id]) }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>

  {{-- @can('edit', \App\Models\ImplementationPlan::class) --}}
  @can('create', \App\Models\ImplementationPlan::class)

  <a class="btn btn-primary pull-right" href="{{ route('implementationplans.edit', ['implementationplan' => $implementationplan->id]) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i>
    {{ trans('admin/implementationplans/general.edit') }}</a>
  @endcan

  {{-- <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
</button> --}}

{{-- <ul class="dropdown-menu" role="menu">
    <li role="menuitem"><a href="{{ route('implementationplans.edit', ['implementationplan' => $implementationplan->id]) }}">{{ trans('admin/implementationplans/general.edit') }}</a></li>
    <li role="menuitem">  <a href="{{route('testtask', $implementationplan->id)}}">{{ trans('admin/tasks/general.create_milestones') }}</a> </li>
  </ul> --}}
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        @can('create', \App\Models\Task::class)
        <li class="active"><a href="#tasks" data-toggle="tab">{{ trans('admin/tasks/form.tasks') }}</a></li>
        @endcan
    
        <li><a href="#uploadedfile" data-toggle="tab">{{ trans('general.uploaded_files') }}</a></li>
    
        @can('create', \App\Models\PaymentSchedule::class)
        <li><a href="#paymentschedules" data-toggle="tab">Payment schedule</a></li>
        @endcan
      </ul>
    
      <div class="tab-content">
    
        @can('index', \App\Models\Task::class)
        <div class="tab-pane active" id="tasks">
          <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listoftasks') }}</h2>
                  </div>
                </div><!-- /.box-header -->   
                   <div class="box">
                <div class="box-body">
                  <table
                  data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
                  data-cookie-id-table="TaskTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="TaskTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.tasks.index',['implementationplan_id' => $implementationplan->id]) }}"
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
        @endcan
    
        @can('index', \App\Models\ImplementationFile::class)
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
                  data-columns="{{ \App\Presenters\ImplementationFilePresenter::dataTableLayout() }}"
                  data-cookie-id-table="implementationfilesTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="implementationfilesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.implementationuploads.index',['implementationplan_id' => $implementationplan->id]) }}"
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
        @endcan
    </div>
  </div>
</div>

<div class="col-md-3">

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">{{trans('general.details')}}</h3>
    </div>
    <div class="panel-body">
      
      @if (!is_null($implementationplan->contractor))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.contractors') }}</strong>
        </div>
        <div class="col-md-8">
          <a href="{{ url('/contractors/' . $implementationplan->contractor->id) }}"> {{ $implementationplan->contractor->name }} </a>
        </div>
      </div>
      @endif

      @if (!is_null($implementationplan->supplier))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.suppliers') }}</strong>
        </div>
        <div class="col-md-8">
          <a href="{{ url('/suppliers/' . $implementationplan->supplier->id) }}"> {{ $implementationplan->supplier->name }} </a>
        </div>
      </div>
      @endif

     @if ($implementationplan->contract_start_date)
       <div class="row">
         <div class="col-md-4">
           <strong>
             {{ trans('admin/implementationplans/form.start_date') }}
           </strong>
         </div>
         <div class="col-md-8">
           {{ \App\Helpers\Helper::getFormattedDateObject($implementationplan->contract_start_date, 'date', false) }}
         </div>
       </div>
     @endif
     
     @if (isset($implementationplan->contract_end_date))
     <div class="row">
       <div class="col-md-4">
         <strong>
           {{ trans('admin/implementationplans/form.end_date') }}
         </strong>
       </div>
       <div class="col-md-8">
         {{ \App\Helpers\Helper::getFormattedDateObject($implementationplan->contract_end_date, 'date', false) }}
       </div>
     </div>
     @endif

     @if ($implementationplan->contract_duration)
     <div class="row">
       <div class="col-md-4">
         <strong>
           {{ trans('general.duration') }}
         </strong>
       </div>
       <div class="col-md-8">
         {!! nl2br(e($implementationplan->contract_duration)) !!}
       </div>
     </div>
     @endif

     @if ($implementationplan->actual_start_date)
     <div class="row">
       <div class="col-md-4">
         <strong>
           {{ trans('admin/implementationplans/form.actual_start_date') }}
         </strong>
       </div>
       <div class="col-md-8">
         {{ \App\Helpers\Helper::getFormattedDateObject($implementationplan->actual_start_date, 'date', false) }}
       </div>
     </div>
   @endif
   
   @if (isset($implementationplan->actual_end_date))
   <div class="row">
     <div class="col-md-4">
       <strong>
         {{ trans('admin/implementationplans/form.actual_end_date') }}
       </strong>
     </div>
     <div class="col-md-8">
       {{ \App\Helpers\Helper::getFormattedDateObject($implementationplan->actual_end_date, 'date', false) }}
     </div>
   </div>
   @endif

   @if ($implementationplan->actual_duration)
   <div class="row">
     <div class="col-md-4">
       <strong>
         {{ trans('general.actual_duration') }}
       </strong>
     </div>
     <div class="col-md-8">
       {!! nl2br(e($implementationplan->actual_duration)) !!}
     </div>
   </div>
   @endif

     @if ($implementationplan->details)
     <div class="row">
       <div class="col-md-4">
         <strong>
           {{ trans('general.details') }}
         </strong>
       </div>
       <div class="col-md-8">
         {!! nl2br(e($implementationplan->details)) !!}
       </div>
     </div>
     @endif
    </div>
  </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Project Plan Action</h3>
        </div>
        <div class="panel-body">

          <br>
          <div>
            {{-- @can('create', \App\Models\Task::class)
            <a  href="{{route('testtask', $implementationplan->id)}}" class="btn btn-primary btn-sm ">
              <i class="fa fa-university" aria-hidden="true"></i>
              {{ trans('admin/tasks/general.create_maintask') }} </a>
            @endcan --}}

            {{-- @can('create', \App\Models\Task::class)
          <a  type="button" class="btn btn-primary btn-sm "   href="{{route('testtask', $implementationplan->id)}}">
            <i class="fa fa-university" aria-hidden="true"></i>
            {{ trans('admin/tasks/general.create_maintask') }}</a>
          @endcan --}}


          @can('create', \App\Models\ImplementationFile::class)
          <a href="{{ route('implementationuploads.create',['id' => $implementationplan->id]) }}" class="btn btn-primary btn-sm btn">
            <i class="fa fa-upload" aria-hidden="true"></i>
            {{ trans('general.upload_file') }}</a>
          @endcan
          </div>
        </div>
      </div>
  </div>
</div>


{{-- <div class="row">
  <div class="col-md-12">
    <div class="container row-striped">

      

    </div>
  </div>
 
</div> --}}

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'task' . $implementationplan->name . '-export', 'search' => false])
@stop