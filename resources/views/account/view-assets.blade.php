@extends('layouts/default')

{{-- Page title --}}
@section('title')
 Staff  {{ $user->present()->fullName() }}
@parent
@stop

{{-- Account page content --}}
@section('content')

<div class="row">

  {{-- add by farez 18/5 --}}
  @can('index', \App\Models\Project::class)
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
      <a href="{{ route('projects.index') }}">
    <div class="small-box bg-green">
      <div class="inner">
        <h3> {{ number_format($counts['project']) }}</h3>
        {{-- <h3> 0 </h3> --}}
          <p>{{ trans('general.total_project') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
        <i class="fa fa-tasks"></i>
      </div>
      @can('index', \App\Models\Project::class)
        <a href="{{ route('projects.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
      @can('create', \App\Models\Project::class)
      <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm btn-block"> {{ trans('general.create') }}
      @endcan
      </a>
    </div>
  </div><!-- ./col -->
  @endcan
  
  @can('index', \App\Models\Contractor::class)
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
      <a href="{{ route('contractors.index') }}">
    <div class="small-box bg-red">
      <div class="inner">
        <h3> {{ number_format($counts['contractor']) }}</h3>
        {{-- <h3> 0 </h3> --}}
          <p>{{ trans('general.total_contractors') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
        <i class="fa fa-address-book" aria-hidden="true"></i>
      </div>
      @can('index', \App\Models\Contractor::class)
        <a href="{{ route('contractors.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->
  @endcan
 
  @can('index', \App\Models\Client::class)
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
      <a href="{{ route('clients.index') }}">
    <div class="small-box bg-purple">
      <div class="inner">
        <h3> {{ number_format($counts['client']) }}</h3>
        {{-- <h3> 0 </h3> --}}
          <p>{{ trans('general.total_client') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
        <i class="fa fa-address-card" aria-hidden="true"></i>
      </div>
      @can('index', \App\Models\Client::class)
        <a href="{{ route('clients.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->
  @endcan
{{-- end add --}}
</div>

{{--  18/6/2021  add by farez --}}
@can('index', \App\Models\Contractor::class)
<div class="col-lg-2 col-xs-3">
  <!-- small box -->
  {{--  contarctor count --}}
    <a href="{{ route('contractors.index') }}">
  <div class="small-box bg-red">
    <div class="inner">
      <h3> {{ number_format($counts['contractor']) }}</h3>
      {{-- <h3> 0 </h3> --}}
        <p>{{ trans('general.contractors') }}</p>
    </div>
    <div class="icon" aria-hidden="true">
      <i class="fa fa-address-book" aria-hidden="true"></i>
    </div>
    @can('index', \App\Models\Contractor::class)
      <a href="#contractors" data-toggle="tab" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
    @endcan
    @can('create', \App\Models\Contractor::class)
    <a href="{{ route('contractors.create') }}" class="btn btn-primary btn-sm btn-block">  {{ trans('general.create') }}  </a>
    @endcan
  </div>
</div><!-- ./col -->
@endcan
{{--  clients count --}}
@can('create', \App\Models\Client::class)
<div class="col-lg-2 col-xs-3">
  <!-- small box -->
    <a href="{{ route('clients.index') }}">
  <div class="small-box bg-purple">
    <div class="inner">
      <h3> {{ number_format($counts['client']) }}</h3>
      {{-- <h3> 0 </h3> --}}
        <p>{{ trans('general.clients') }}</p>
    </div>
    <div class="icon" aria-hidden="true">
      <i class="fa fa-address-card" aria-hidden="true"></i>
    </div>
    @can('index', \App\Models\Client::class)
      <a href="#clients" data-toggle="tab" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
    @endcan
    @can('create', \App\Models\Client::class)
    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm btn-block">  {{ trans('general.create') }}</a>
    @endcan
  </div>
</div><!-- ./col -->
@endcan
</div> <!--end row-->
{{-- end add --}}


<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
  @can('index', \App\Models\Project::class)
  <li class="active" ><a href="#projects" data-toggle="tab">{{ trans('general.projects') }}</a></li>
  @endcan
  @can('index', \App\Models\Contractor::class)
  <li><a href="#contractors" data-toggle="tab">{{ trans('general.contractors') }}</a></li>
  @endcan
  @can('index', \App\Models\Client::class)
  <li><a href="#clients" data-toggle="tab">{{ trans('general.clients') }}</a></li>
  @endcan
</ul>

<div class="tab-content">
  @can('index', \App\Models\Project::class)
  <div class="tab-pane active" id="projects">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-body">
    
              <table
                  data-columns="{{ \App\Presenters\ProjectPresenter::dataTableLayout() }}"
                  data-cookie-id-table="projectTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="projectsTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.projects.index') }}"
                  data-export-options='{
                "fileName": "export-projects-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","icon"]
                }'>
              </table>
    
          </div><!-- /.box-body -->
    
        
          </div>
        </div><!-- /.box -->
    </div>  
  </div> <!-- end details -->
  @endcan

  @can('index', \App\Models\Contractor::class)
  <div class="tab-pane " id="contractors">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
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
                <th data-sortable="true" data-field="id" data-visible="true">{{ trans('admin/contractors/table.id') }}</th>
                <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="true"  data-searchable="false">{{ trans('general.image') }}</th>
                <th data-sortable="true"   data-visible="true" data-field="name" data-formatter="contractorsLinkFormatter">{{ trans('admin/contractors/table.name') }}</th>
                <th data-sortable="true"   data-visible="true" data-field="address">{{ trans('admin/contractors/table.address') }}</th>
                <th data-searchable="true" data-visible="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/contractors/table.email') }}</th>
                <th data-searchable="true" data-visible="true" data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/contractors/table.phone') }}</th>
                <th data-searchable="true" data-visible="true" data-sortable="true" data-field="fax" data-visible="true">{{ trans('admin/contractors/table.fax') }}</th>
                <th data-sortable="true"   data-visible="true" data-field="url"  data-formatter="externalLinkFormatter">{{ trans('admin/contractors/table.url') }}</th>
                <th data-switchable="false" data-visible="true" data-formatter="contractorsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
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

 @can('index', \App\Models\Client::class)
  <div class="tab-pane " id="clients">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-body">
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
                <th data-sortable="true" data-field="id" data-visible="true">{{ trans('admin/clients/table.id') }}</th>
                <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="true"  data-searchable="false">{{ trans('general.image') }}</th>
                <th data-sortable="true"    data-visible="true"  data-field="name" data-formatter="clientsLinkFormatter">{{ trans('admin/clients/table.name') }}</th>
                <th data-sortable="true"    data-visible="true"  data-field="address">{{ trans('admin/clients/table.address') }}</th>
                <th data-searchable="true"  data-visible="true" data-sortable="true" data-field="contact">{{ trans('admin/clients/table.contact') }}</th>
                <th data-searchable="true"  data-visible="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/clients/table.email') }}</th>
                <th data-searchable="true"  data-visible="true"data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/clients/table.phone') }}</th>
                <th data-searchable="true"  data-visible="true" data-sortable="true" data-field="fax">{{ trans('admin/clients/table.fax') }}</th>
                <th data-sortable="true"    data-visible="true" data-field="url"  data-formatter="externalLinkFormatter">{{ trans('admin/clients/table.url') }}</th>
                <th data-switchable="false" data-visible="true" data-formatter="clientsActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div> <!-- end  clients-->
@endcan


<div>
</div><!-- end tabs custom  -->





@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
