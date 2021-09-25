@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/projects/general.projects') }}
@parent
@stop



@section('header_right')

@can('create', \App\Models\Project::class)
   
    @endcan
    
@stop

{{-- Page content --}}
@section('content')

  {{-- add by farez 18/5 --}}
<div class="row"> 
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
      <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm btn-block">
        {{ trans('general.create') }}
      </a>
    </div>
    
    {{-- <a href="{{ route('hardware.create',['id' => $project->id]) }}" class="btn btn-success btn-sm btn-block"></i> {{ trans('general.create') }}</a> --}}

  </div><!-- ./col -->
{{-- end add --}}

  {{--  18/6/2021  add by farez --}}
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
        <i class="fa fa-suitcase"></i>
      </div>
      @can('index', \App\Models\Contractor::class)
        <a href="{{ route('contractors.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
      <a href="{{ route('contractors.create') }}" class="btn btn-primary btn-sm btn-block">
        {{ trans('general.create') }}
      </a>
    </div>
  </div><!-- ./col -->

  {{--  clients count --}}
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
        <i class="fa fa-suitcase"></i>
      </div>
      @can('index', \App\Models\Client::class)
        <a href="{{ route('clients.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
      <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm btn-block">
        {{ trans('general.create') }}
      </a>
    </div>
  </div><!-- ./col -->

</div> <!--end row-->
{{-- end add --}}


<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#projects" data-toggle="tab">{{ trans('general.projects') }}</a></li>
    <li><a href="#contractors" data-toggle="tab">{{ trans('general.contractors') }}</a></li>
    <li><a href="#clients" data-toggle="tab">{{ trans('general.clients') }}</a></li>
    {{-- <li><a href="#history" data-toggle="tab">{{ trans('admin/project/general.checkout_history') }}</a></li> --}}
    {{-- <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}</a></li> --}}
  </ul>

  <div class="tab-content">

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
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/contractors/table.id') }}</th>
                  <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
                  <th data-sortable="true" data-field="name" data-formatter="contractorsLinkFormatter">{{ trans('admin/contractors/table.name') }}</th>
                
                  <th data-sortable="true" data-field="project" data-formatter="projectsLinkFormatter">{{ trans('admin/contractors/table.projects') }}</th>

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


    <div class="tab-pane " id="clients">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-body">
            <div class="table-responsive">
      
              <table
                  data-cookie-id-table="worksTable"
                  data-pagination="true"
                  data-id-table="worksTable"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="worksTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.works.index') }}"
                  data-export-options='{
                  "fileName": "export-works-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                  }'>
              <thead>
                <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/works/table.id') }}</th>
                  <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
                  <th data-sortable="true" data-field="name" data-formatter="worksLinkFormatter">{{ trans('admin/works/table.name') }}</th>
                  <th data-sortable="true" data-field="address">{{ trans('admin/works/table.address') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="contact">{{ trans('admin/works/table.contact') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/works/table.email') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/works/table.phone') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">{{ trans('admin/works/table.fax') }}</th>
                  <th data-sortable="true" data-field="url" data-visible="false" data-formatter="externalLinkFormatter">{{ trans('admin/works/table.url') }}</th>
                  <th data-switchable="false" data-formatter="worksActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                </tr>
              </thead>
            </table>
            </div>
          </div>
        </div>
        </div>
      </div>

    </div> <!-- end  clients-->



  <div>
</div><!-- end tabs custom  -->





@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop
