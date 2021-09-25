@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/statustasks/table.statustasks') }}
@parent
@stop

{{-- Page content --}}
@section('content')


@section('header_right')

  <a href="{{ route('statustasks.create') }}" class="btn btn-primary pull-right">
    {{ trans('general.create') }}</a>
@stop


@section('content')

  {{-- add by farez 18/5 --}}
<div class="row"> 
  <div class="tab-pane " id="statustasks">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
          <div class="table-responsive">
    
            <table
                data-cookie-id-table="statustasksTable"
                data-pagination="true"
                data-id-table="statustasksTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                id="statustasksTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.statustasks.index') }}"
                data-export-options='{
                "fileName": "export-statustask-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/statustask/table.id') }}</th>
                <th data-sortable="true" data-field="name" data-formatter="statustasksLinkFormatter">{{ trans('admin/statustasks/table.name') }}</th>
                <th data-switchable="false" data-formatter="statustasksActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
          </div>
        </div>
      </div>
      </div>
    </div>

  </div> <!-- end  statustask-->

</div>
 




@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop