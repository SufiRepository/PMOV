@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/assignworks/table.assignwork') }}
@parent
@stop

{{-- Page content --}}
@section('content')


@section('header_right')
  {{-- @can('create', \App\Models\Assignwork::class)
    <a href="{{ route('assignworks.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan --}}

  <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@stop

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
      <div class="table-responsive">

        <table
            data-cookie-id-table="assignworksTable"
            data-pagination="true"
            data-id-table="assignworksTable"
            data-search="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true"
            data-show-refresh="true"
            data-sort-order="asc"
            id="assignworksTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.assignworks.index') }}"
            data-export-options='{
            "fileName": "export-assignworks-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
        <thead>
          <tr>
            <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/assignworkd/table.id') }}</th>
            <th data-sortable="true" data-field="project" data-formatter="projectsLinkObjFormatter">{{ trans('admin/projects/table.name') }}</th>
            <th data-sortable="true" data-field="contractor" data-formatter="contractorsLinkObjFormatter">{{ trans('admin/contractor/table.name') }}</th>
            <th data-switchable="false" data-formatter="assignworksActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
          </tr>
        </thead>
      </table>
      </div>
    </div>
  </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'suppliers-export', 'search' => true])
@stop
