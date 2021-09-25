@extends('layouts/default')

{{-- Page title --}}

@section('title')
{{-- {{ trans('admin/manufacturers/table.asset_manufacturers') }}  --}}
{{ trans('Helpdesks') }} 
@parent
@stop

  
@section('header_right')
   <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>

    @can('create', \App\Models\Helpdesk::class)
    <a href="{{ route('helpdesks.create') }}" class="btn btn-primary pull-right" style="margin-right: 10px">
      Create Issue</a>
    @endcan

    <a href="{{ route('helpdeskcreatetask') }}" class="btn btn-primary pull-right" style="margin-right: 10px">
      Create Task</a>
@stop

  
  {{-- @if (Request::get('deleted')=='true')
    <a class="btn btn-default pull-right" href="{{ route('helpdesks.index') }}" style="margin-right: 5px;">{{ trans('general.show_current') }}</a>
  @else
    <a class="btn btn-default pull-right" href="{{ route('helpdesks.index', ['deleted' => 'true']) }}" style="margin-right: 5px;">
      {{ trans('general.show_deleted') }}</a>
  @endif --}}
  



{{-- Page content --}}
@section('content')

  <div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
            data-columns="{{ \App\Presenters\HelpdeskPresenter::dataTableLayout() }}"
            data-cookie-id-table="helpdesksTable"
            data-pagination="true"
            data-id-table="helpdesksTable"
            data-search="true"
            data-show-footer="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true" 
            data-show-refresh="true"
            data-sort-order="asc"
            id="helpdesksTable"
            class="table table-striped snipe-table"
            data-url="{{route('api.helpdesks.index', ['deleted' => e(Request::get('deleted')) ]) }}"
            data-export-options='{
              "fileName": "export-helpdesks-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>

          </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
  </div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
