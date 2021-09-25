@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Team') }}
@parent
@stop

{{-- @section('header_right')
    @can('create', \App\Models\Task::class)
        <a href="{{ route('teams.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop --}}

{{-- Right header --}}
@section('header_right')
<div class="btn-group pull-right">
  <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    Add new team member
  </a>
</div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <table
                data-columns="{{ \App\Presenters\TeamPresenter::dataTableLayout() }}"
                data-cookie-id-table="teamsTable"
                data-pagination="true"
                data-id-table="teamTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                data-toolbar="#toolbar"
                id="teamsTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.teams.index') }}"
                data-export-options='{
                "fileName": "export-teams-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","icon"]
                }'>
        </table>

      </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'Tasks-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\TaskPresenter::dataTableLayout()])
@stop