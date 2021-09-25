@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('implementationplans') }}
@parent
@stop

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ URL::previous() }}" class="btn btn-primary">
    {{ trans('general.back') }}</a>
    {{-- <a href="{{ route('implementationplans.create') }}" class="btn btn-default" >
      {{ trans('general.create') }}</a> --}}
</div>

@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="{{ \App\Presenters\ImplementationPlanPresenter::dataTableLayout() }}"
              data-cookie-id-table="ImplementationPlanTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="implementationplansTable"

              class="table table-striped snipe-table"
              data-url="{{ route('api.implementationplans.index') }}"
              data-export-options='{
            "fileName": "export-implementationplans-{{ date('Y-m-d') }}",
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
@include ('partials.bootstrap-table', ['exportFile' => 'ImplementationPlans-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\ImplementationPlanPresenter::dataTableLayout()])
@stop