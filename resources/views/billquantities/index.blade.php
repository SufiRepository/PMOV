@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/billquantities/table.billquantities') }}
@parent
@stop

{{-- Page content --}}
@section('content')
@section('header_right')
@stop
@section('content')

  {{-- add by farez 18/5 --}}
<div class="row"> 

{{--  billquantities count --}}
<div class="col-lg-2 col-xs-3">
  <!-- small box -->
    <a href="#billquantities" data-toggle="tab">
  <div class="small-box bg-purple">
    <div class="inner">
      {{-- <h3> {{ number_format($counts['client']) }}</h3> --}}
      
        <p>{{ trans('general.billquantities') }}</p>
    </div>
    <div class="icon" aria-hidden="true">
      <i class="fa fa-address-card" aria-hidden="true"></i>
    </div>
    {{-- @can('index', \App\Models\BillQuantity::class) --}}
      <a href="#billquantities" data-toggle="tab"class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
    {{-- @endcan --}}
    {{-- @can('create', \App\Models\BillQuantity::class) --}}
    <a href="{{ route('billquantities.create') }}" class="btn btn-primary btn-sm btn-block">  {{ trans('general.create') }}</a>
    {{-- @endcan --}}
  </div>
</div><!-- ./col -->


    
</div> <!--end row-->
{{-- end add --}}


<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">

    @can('index', \App\Models\Client::class)
    <li class="active" ><a href="#billquantities" data-toggle="tab">{{ trans('general.billquantities') }}</a></li>
    @endcan
  </ul>

  <div class="tab-content">

   @can('index', \App\Models\BillQuantity::class)
    <div class="tab-pane " id="billquantities">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
                <table
                    data-columns="{{ \App\Presenters\BillQuantityPresenter::dataTableLayout() }}"
                    data-cookie-id-table="billquantitiesTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="billquantitiesTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.billquantities.index') }}"
                    data-export-options='{
                  "fileName": "export-billquantities-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","icon"]
                  }'>
                </table>
              </div><!-- /.box-body -->
            </div>
          </div><!-- /.box -->
      </div>  
    </div> <!-- end details -->
  @endcan



{{-- @can('index', \App\Models\Client::class)
    <div class="tab-pane active " id="billquantities">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-body">
            <div class="table-responsive">
      
              <table
                  data-cookie-id-table="billquantitiesTable"
                  data-pagination="true"
                  data-id-table="billquantitiesTable"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="billquantitiesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.billquantities.index') }}"
                  data-export-options='{
                  "fileName": "export-billquantities-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                  }'>
              <thead>
                <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/billquantities/table.id') }}</th>
                  <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
                  <th data-sortable="true" data-field="name" data-formatter="billquantities">{{ trans('admin/billquantities/table.name') }}</th>
                  <th data-sortable="true"    data-visible="true"  data-field="department" data-formatter="billquantities">{{ trans('admin/billquantities/table.department') }}</th>
                  <th data-sortable="true" data-field="address">{{ trans('admin/billquantities/table.address') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="contact">{{ trans('admin/billquantities/table.contact') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/billquantities/table.email') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/billquantities/table.phone') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">{{ trans('admin/billquantities/table.fax') }}</th>
                  <th data-sortable="true" data-field="url" data-visible="false" data-formatter="externalLinkFormatter">{{ trans('admin/billquantities/table.url') }}</th>
                  <th data-switchable="false" data-formatter="billquantities" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                </tr>
              </thead>
            </table>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div> <!-- end  clients-->
@endcan --}}


    
</div><!-- end tabs custom  -->





@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop