@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/contractors/table.contractors') }}
@parent
@stop

{{-- Page content --}}
@section('content')
@section('header_right')

<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">{{ trans('general.back') }}</a>

@can('create', \App\Models\Client::class)
<a href="{{ route('contractors.create') }}"  class="btn btn-primary pull-right" style="margin-right: 5px;">  {{ trans('general.new_contractor') }}</a>
@endcan
@stop

    @can('index', \App\Models\Contractor::class)
    <div class="tab-pane active" id="contractors">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-body">
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title"> {{ trans('general.listofcontractors') }}</h2>
                </div>
              </div><!-- /.box-header -->
    
            <div class="table-responsive">
              <table
                  data-cookie-id-table="contractorsTable"
                  data-pagination="true"
                  data-id-table="contractorsTable"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="contractorsTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.contractors.index') }}"
                  data-export-options='{
                  "fileName": "export-contractors-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                  }'>
              <thead>
                <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/contractors/table.id') }}</th>
                  <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
                  <th data-sortable="true" data-field="name" data-formatter="contractorsLinkFormatter">{{ trans('admin/contractors/table.name') }}</th>
                  <th data-sortable="true" data-field="address">{{ trans('admin/contractors/table.address') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="contact">{{ trans('admin/contractors/table.contact') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/contractors/table.email') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/contractors/table.phone') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">{{ trans('admin/contractors/table.fax') }}</th>
                  <th data-sortable="true" data-field="url" data-visible="false" data-formatter="externalLinkFormatter">{{ trans('admin/contractors/table.url') }}</th>
                  <th data-switchable="false" data-formatter="contractorsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                </tr>
              </thead>
            </table>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div> <!-- end tasks -->
@endcan
   
 @stop
@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop