@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/roles/table.view') }} -
{{ $role->name }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">  {{ trans('general.back') }}</a>

@can('create', \App\Models\Role::class)
  <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-default pull-right">
  {{ trans('admin/roles/table.update') }}</a>
@endcan
@stop

{{-- Page content --}}
@section('content')

<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
    <li><a href="#milestones" data-toggle="tab">  {{ trans('admin/roles/form.milestones') }}</a></li>
    <li><a href="#tasks" data-toggle="tab">  {{ trans('admin/roles/form.tasks') }}</a></li>
    <li><a href="#subtasks" data-toggle="tab">  {{ trans('admin/roles/form.subtasks') }}</a></li>

  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="details">
      <div class="row">
        <div class="col-md-12">
           <div class="container row-striped">
      
              @if ($role->name)
              <div class="row">
                <div class="col-md-4">
                  <strong>
                    {{ trans('admin/roles/form.to_name') }}
                  </strong>
                  </div>
                  <div class="col-md-8">
                  {!! nl2br(e($role->name)) !!}
                  </div>
              </div>
              @endif
             @if (!is_null($role->company))
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('general.company') }}</strong>
                    </div>
                    <div class="col-md-8">
                      <a href="{{ url('/companies/' . $role->company->id) }}">{{ $role->company->name }}</a>
                    </div>
                  </div>
              @endif

           </div>
        </div>
      </div>
    </div>

{{-- @can('index', \App\Models\Task::class)
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
            id="taskTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.tasks.index',['role_id' => $role->id]) }}"
            data-export-options='{
          "fileName": "export-tasks-{{ date('Y-m-d') }}",
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
@endcan --}}

{{-- @can('index', \App\Models\Subtask::class)
<div class="tab-pane" id="subtasks">
  <div class="row">
    <div class="col-md-12">
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
          data-url="{{ route('api.subtasks.index',['role_id' => $role->id]) }}"
          data-export-options='{
        "fileName": "export-subtasks-{{ date('Y-m-d') }}",
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
 --}}




  <!-- side address column -->
  {{-- <div class="col-md-3">

    @if (($contractor->state!='') && ($contractor->country!='') && (config('services.google.maps_api_key')))
      <div class="col-md-12 text-center" style="padding-bottom: 20px;">
        <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($contractor->address.','.$contractor->city.' '.$contractor->state.' '.$contractor->country.' '.$contractor->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
      </div>
    @endif


    <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px; padding-top: 20px;">
      @if ($contractor->contact)
      <li><i class="fa fa-user" aria-hidden="true"></i> {{ $contractor->contact }}</li>
      @endif

      @if ($contractor->phone)
      <li><i class="fa fa-phone"></i>
        <a href="tel:{{ $contractor->phone }}">{{ $contractor->phone }}</a>
      </li>
      @endif

      @if ($contractor->fax)
      <li><i class="fa fa-print"></i> {{ $contractor->fax }}</li>
      @endif

      @if ($contractor->email)
      <li>
        <i class="fa fa-envelope-o"></i>
        <a href="mailto:{{ $contractor->email }}">
        {{ $contractor->email }}
        </a>
      </li>
      @endif

      @if ($contractor->url)
      <li>
        <i class="fa fa-globe"></i>
        <a href="{{ $contractor->url }}" target="_new">{{ $contractor->url }}</a>
      </li>
      @endif

      @if ($contractor->address)
      <li><br>
        {{ $contractor->address }}

        @if ($contractor->address2)
        <br>
        {{ $contractor->address2 }}
        @endif
        @if (($contractor->city) || ($contractor->state))
        <br>
        {{ $contractor->city }} {{ strtoupper($contractor->state) }} {{ $contractor->zip }} {{ strtoupper($contractor->country) }}
        @endif
      </li>
      @endif

      @if ($contractor->notes)
      <li><i class="fa fa-comment"></i> {{ $contractor->notes }}</li>
      @endif

    </ul>
      @if ($contractor->image!='')
        <div class="col-md-12 text-center" style="padding-bottom: 20px;">
          <img src="{{ Storage::disk('public')->url(app('roles_upload_url').e($contractor->image)) }}" class="img-responsive img-thumbnail" alt="{{ $contractor->name }}">
        </div>
      @endif

  </div> <!--/col-md-3--> --}}




@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table', [  'showFooter' => true, ])
@stop
