@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/projects/general.view') }}
- {{$project->name}}
@parent
@stop



{{-- Right header --}}
@section('header_right')
<div class="btn-group pull-right">
  <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
  @can('update', $project)
    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li role="menuitem"><a href="{{ route('projects.edit', ['project' => $project->id]) }}">{{ trans('admin/projects/general.edit') }}</a></li>
        {{-- <li role="menuitem"><a href="{{ route('clone/project', $project->id) }}">{{ trans('admin/projects/general.clone') }}</a></li> --}}
    </ul>
   @endcan
</div>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
     {{-- total  all  --}}
     <div class="col-lg-2 col-xs-3">
      <!-- small box -->
        {{-- <a href="{{ route('consumables.index') }}"> --}}
      <div class="small-box bg-purple">
        <div class="inner">
          <h3> {{ number_format($counts['grand_total']) }}</h3>
            <p>{{ trans('general.total_assets') }}</p>
        </div>
      <div class="icon" aria-hidden="true">
          <i class="fa fa-barcode"></i>
       </div>
        
 {{-- to view all asset --}}
        <div class="dropdown">
          <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            More Info
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @can('index', \App\Models\Asset::class)
            <a  type="button" class="dropdown-item" href="{{ route('hardware.index',['id' => $project->id]) }}">{{ trans('general.asset') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            @endcan
            <div class="dropdown-divider"></div>
            @can('view', \App\Models\License::class)
            <a type="button"class="dropdown-item" href="{{ route('licenses.index',['id' => $project->id]) }}">{{ trans('general.licenses') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            @endcan
            <div class="dropdown-divider"></div>
            @can('index', \App\Models\Accessory::class)
            <a type="button"class="dropdown-item" href="{{ route('accessories.index',['id' => $project->id]) }}">{{ trans('general.accessories') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            @endcan
            
            <div class="dropdown-divider"></div>
            @can('index', \App\Models\Consumable::class)
            <a type="button" class="dropdown-item" href="{{ route('consumables.index',['id' => $project->id]) }}">{{ trans('general.consumables') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
             @endcan
          </div>
        </div>
{{-- create new --}}
        <div class="dropdown">
          <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            create New
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a  type="button" class="dropdown-item" href="{{ route('hardware.create',['id' => $project->id]) }}">New Asset</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('licenses.create',['id' => $project->id]) }}">New License</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('accessories.create',['id' => $project->id]) }}">New Accessories</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('consumables.create',['id' => $project->id]) }}">New Consumable</a>
          </div>
        </div>



      </div>
    </div><!-- ./col -->

 {{-- total  task  --}}
 <div class="col-lg-2 col-xs-3">
  <!-- small box -->
    {{-- <a href="{{ route('consumables.index') }}"> --}}
  <div class="small-box bg-green">
    <div class="inner">
      <h3> {{ number_format($counts['task']) }}</h3>
        <p>{{ trans('general.total_task') }}</p>
    </div>
  <div class="icon" aria-hidden="true">
    <i class="fa fa-briefcase" aria-hidden="true"></i>
   </div>
    
{{-- to view all asset --}}
    <div class="dropdown">
      <a href="{{ route('tasklist/project',$project->id)}}" class="btn btn-danger  btn-sm btn-block ">
        {{ trans('general.moreinfo') }}
      </a>
     
    </div>
{{-- create new --}}
    <div class="dropdown">
      <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        New Task
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a  type="button" class="dropdown-item" href="{{ route('tasks.create',['id' => $project->id]) }}">New Task</a>
        <div class="dropdown-divider"></div>
        {{-- <a class="dropdown-item" href="{{ route('licenses.create',['id' => $project->id]) }}">New License</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('accessories.create',['id' => $project->id]) }}">New Accessories</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('consumables.create',['id' => $project->id]) }}">New Consumable</a> --}}
      </div>
    </div>



  </div>
</div><!-- ./col -->

<div class="col-lg-2 col-xs-3">
  <!-- small box -->
    {{-- <a href="{{ route('consumables.index') }}"> --}}
  <div class="small-box bg-orange">
    <div class="inner">
      <h3> {{ number_format($counts['grand_total']) }}</h3>
        <p>Total Gantt Chart</p>
    </div>
  <div class="icon" aria-hidden="true">
    <i class="fa fa-bar-chart" aria-hidden="true"></i>
   </div>
    
{{-- to view all asset --}}
    {{-- <div class="dropdown">
      <a href="{{ route('tasklist/project',$project->id)}}" class="btn btn-danger  btn-sm btn-block ">
        {{ trans('general.moreinfo') }}
      </a>
     
    </div> --}}
{{-- create new gantt chart--}}
    <div class="dropdown">
      <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        New Gantt Chart
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a  type="button" class="dropdown-item" href="{{ route('gantt-chart.create',['id' => $project->id]) }}">New Gantt Chart</a>
      </div>
    </div>
  </div>
</div><!-- ./col -->


{{--  view total contractor on project --}}
<div class="col-lg-2 col-xs-3">
  <!-- small box -->

    <a href="{{ route('assignworks.index') }}">
  <div class="small-box bg-purple">
    <div class="inner">
      {{-- <h3> {{ number_format($counts['client']) }}</h3> --}}
      <h3> 0 </h3>
        <p>{{ trans('general.assignwork') }}</p>
    </div>
    <div class="icon" aria-hidden="true">
      <i class="fa fa-industry" aria-hidden="true"></i>
    </div>
    @can('index', \App\Models\AssignWork::class)
    <div class="dropdown">
      <a href="{{ route('assignworks.index',$project->id)}}" class="btn btn-danger  btn-sm btn-block ">
        {{ trans('general.moreinfo') }}
      </a>
     
    </div>
      {{-- <a href="{{ route('assignworks.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a> --}}
    @endcan
    <a href="{{ route('assignworks.create',['id' => $project->id]) }}" class="btn btn-danger btn-sm btn-block">
      {{ trans('general.create') }}
    </a>
  </div>
</div><!-- ./col -->

    </div>

    
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
        <li><a href="#tasks" data-toggle="tab">{{ trans('admin/project/form.tasks') }}</a></li>
        {{-- <li><a href="{{ route('api.teams.index') }}" data-toggle="tab">{{ trans('Team') }}</a></li> --}}
        {{-- <li><a href="#uploads" data-toggle="tab">{{ trans('general.file_uploads') }}</a></li> --}}
        {{-- <li><a href="#history" data-toggle="tab">{{ trans('admin/project/general.checkout_history') }}</a></li> --}}
        {{-- <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}</a></li> --}}
      </ul>
      
      <div class="tab-content">

        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-12">
              <div class="container row-striped">

                @if ($project->name)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/projects/form.to_name') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {!! nl2br(e($project->name)) !!}
                  </div>
                </div>
                @endif
              
                @if (!is_null($project->user))
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.user') }}</strong>
                  </div>
                  <div class="col-md-8">
                    {{-- <a href="{{ url('/user/' . $project->user->id) }}"> {{ $project->user->username }} </a> --}}
                    {{ $project->user->username }}
                  </div>
                </div>
              @endif

                @if (!is_null($project->company))
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('general.company') }}</strong>
                    </div>
                    <div class="col-md-8">
                      <a href="{{ url('/companies/' . $project->company->id) }}">{{ $project->company->name }}</a>
                    </div>
                  </div>
                @endif

                {{-- new add by farez 28/5/2021 --}}

                @if (!is_null($project->location))
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.location') }}</strong>
                  </div>
                  <div class="col-md-8">
                    <a href="{{ url('/locations/' . $project->location->id) }}"> {{ $project->location->name }} </a>
                  </div>
                </div>
              @endif

              {{-- new add by farez 8/6/2021 --}}

              @if (!is_null($project->client))
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.client') }}</strong>
                </div>
                <div class="col-md-8">
                  <a href="{{ url('/clients/' . $project->client->id) }}"> {{ $project->client->name }} </a>
                </div>
              </div>
            @endif
            {{-- end add --}}

            {{-- new add by farez 16/6/2021 --}}

            @if (!is_null($project->contractor))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.contractors') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/contractors/' . $project->contractor->id) }}"> {{ $project->contractor->name }} </a>
              </div>
            </div>
          @endif
          {{-- end add --}}

                @if ($project->start_date)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('admin/projects/form.start_date') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ \App\Helpers\Helper::getFormattedDateObject($project->due_date, 'date', false) }}
                    </div>
                  </div>
                @endif
                
                @if (isset($project->due_date))
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/projects/form.due_date') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {{ \App\Helpers\Helper::getFormattedDateObject($project->due_date, 'date', false) }}
                  </div>
                </div>
                @endif

                @if ($project->costing > 0)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('general.costing') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ $snipeSettings->default_currency }}
                      {{ \App\Helpers\Helper::formatCurrencyOutput($project->costing) }}
                    </div>
                  </div>
                  @endif

                  @if ($project->details)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('general.details') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {!! nl2br(e($project->details)) !!}
                    </div>
                  </div>
                  @endif
                 
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        Tasks
                      </strong>
                    </div>
                    <div class="col-md-8">
                      <a href="{{ route('tasks.index') }}" {{ (Request::is('/tasks') ? ' class="active"' : '') }}>
                        {{ trans('general.tasks') }}
                    </a>
                      {{-- <a href="{{ route('tasklist/project',$project->id)}}">List of Tasks</a> --}}
                    </div>
                  </div>
              </div> <!-- end row-striped -->


            
      

            </div>
            </div>
          </div> <!-- end tab-pane -->
          <div class="tab-pane" id="tasks">
            <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-body">
            
                      <table
                          data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
                          data-cookie-id-table="taskTable"
                          data-pagination="true"
                          data-search="true"
                          data-side-pagination="server"
                          data-show-columns="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          data-sort-name="name"
                          id="tasksTable"
            
                          class="table table-striped snipe-table"
                          data-url="{{ route('api.tasks.index') }}"
                          data-export-options='{
                        "fileName": "export-tasks-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","icon"]
                        }' >
            
                        {{-- class="table table-striped snipe-table"
                        data-url="{{route('api.tasks.index', ['project_id' => $project->id])}}"
                        data-export-options='{
                        "fileName": "export-tasks-{{ str_slug($task->name) }}-projects-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                          }'> --}}
                        
                      </table>
            
                  </div><!-- /.box-body -->
            
                  <div class="box-footer clearfix">
                  </div>
                </div><!-- /.box -->
              </div>
  
            </div> <!--/.row-->
          </div> <!-- /.tab-pane -->


{{-- @can('update', \App\Models\project::class)
  @include ('modals.upload-file', ['item_type' => 'project', 'item_id' => $project->id])
@endcan --}}

@stop


@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop

