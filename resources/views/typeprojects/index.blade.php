@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/typeprojects/table.typeprojects') }}
@parent
@stop

{{-- Page content --}}
@section('content')


@section('header_right')
  @can('create', \App\Models\Supplier::class)
    <a href="{{ route('typeprojects.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
      <div class="table-responsive">

        <table
            data-cookie-id-table="typeprojectsTable"
            data-pagination="true"
            data-id-table="typeprojectsTable"
            data-search="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true"
            data-show-refresh="true"
            data-sort-order="asc"
            id="typeprojectsTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.typeprojects.index') }}"
            data-export-options='{
            "fileName": "export-typeprojects-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
        <thead>
          <tr>
            <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/typeprojects/table.id') }}</th>
            <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
            <th data-sortable="true" data-field="name" data-formatter="typeprojectsLinkFormatter">{{ trans('admin/typeprojects/table.name') }}</th>
            <th data-switchable="false" data-formatter="typeprojectsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
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
@include ('partials.bootstrap-table', ['exportFile' => 'typeprojects-export', 'search' => true])
@stop
