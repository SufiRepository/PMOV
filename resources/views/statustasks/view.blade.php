@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/statustasks/table.view') }} -
{{ $statustask->name }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">  {{ trans('general.back') }}</a>

@stop

{{-- Page content --}}
@section('content')

<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class ="active"><a href="#tasks" data-toggle="tab">  {{ trans('admin/statustasks/form.tasks') }}</a></li>
    <li><a href="#subtasks" data-toggle="tab">  {{ trans('admin/statustasks/form.subtask') }}</a></li>

  </ul>

  <div class="tab-content">
  
  @can('index', \App\Models\Task::class)
  <div class="tab-pane active" id="tasks">
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
            data-url="{{ route('api.tasks.index',['statustask_id' => $statustask->id]) }}"
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
@endcan

@can('index', \App\Models\Subtask::class)
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
          data-url="{{ route('api.statustasks.index',['statustask_id' => $statustask->id]) }}"
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



@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table', [
      'showFooter' => true,
      ])
@stop
