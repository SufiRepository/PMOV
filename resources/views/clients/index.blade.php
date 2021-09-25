@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/clients/table.clients') }}
@parent
@stop

{{-- Page content --}}
@section('content')
@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">{{ trans('general.back') }}</a>

@can('create', \App\Models\Client::class)
<a href="{{ route('clients.create') }}" class="btn btn-primary pull-right" style="margin-right: 5px;">   {{ trans('general.new_client') }}</a>
@endcan
@stop
@section('content')


<div class="col-md-12">
    @can('index', \App\Models\Client::class)
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
          <div class="box-header with-border">
            <div class="box-heading">
              <h2 class="box-title"> {{ trans('general.listofclients') }}</h2>
            </div>
          </div><!-- /.box-header -->
            <div class="table-responsive">
          
                  <table
                      data-cookie-id-table="clientsTable"
                      data-pagination="true"
                      data-id-table="clientsTable"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      id="clientsTable"
                      class="table table-striped snipe-table"
                      data-url="{{ route('api.clients.index') }}"
                      data-export-options='{
                      "fileName": "export-clients-{{ date('Y-m-d') }}",
                      "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                      }'>
                  <thead>
                    <tr>
                      <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/clients/table.id') }}</th>
                      <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
                      <th data-sortable="true" data-field="name" data-formatter="clientsLinkFormatter">{{ trans('admin/clients/table.name') }}</th>
                      <th data-sortable="true"    data-visible="true"  data-field="department" data-formatter="clientsLinkFormatter">{{ trans('admin/clients/table.department') }}</th>
                      <th data-sortable="true" data-field="address">{{ trans('admin/clients/table.address') }}</th>
                      <th data-searchable="true" data-sortable="true" data-field="contact">{{ trans('admin/clients/table.contact') }}</th>
                      <th data-searchable="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/clients/table.email') }}</th>
                      <th data-searchable="true" data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/clients/table.phone') }}</th>
                      <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">{{ trans('admin/clients/table.fax') }}</th>
                      <th data-sortable="true" data-field="url" data-visible="false" data-formatter="externalLinkFormatter">{{ trans('admin/clients/table.url') }}</th>
                      <th data-switchable="false" data-formatter="clientsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                    </tr>
                  </thead>
                </table>

           </div>
        </div>
      </div>
    </div>
   </div>
   @endcan
</div> 



@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop