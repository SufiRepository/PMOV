@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Roles') }}
@parent
@stop

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ URL::previous() }}" class="btn btn-primary">
    {{ trans('general.back') }}</a>
    <a href="{{ route('roles.create') }}" class="btn btn-default" >
      {{ trans('general.create') }}</a>
</div>

@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="{{ \App\Presenters\RolePresenter::dataTableLayout() }}"
              data-cookie-id-table="roleTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="rolesTable"

              class="table table-striped snipe-table"
              data-url="{{ route('api.roles.index') }}"
              data-export-options='{
            "fileName": "export-roles-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","icon"]
            }' >
            
          </table>

      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'roles-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\RolePresenter::dataTableLayout()])
@stop