@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/projects/general.projects') }}
@parent
@stop



@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">{{ trans('general.back') }}</a>

@can('create', \App\Models\Project::class)
<a href="{{ route('projects.create') }}" class="btn btn-primary pull-right" style="margin-right: 5px;"> {{ trans('general.new_project') }}</a>
@endcan
    
@stop

{{-- Page content --}}
@section('content')

    @can('index', \App\Models\Project::class)
    {{-- <div class="tab-pane active" id="projects"> --}}
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title"> {{ trans('general.listofproject') }}</h2>
                </div>
              </div><!-- /.box-header -->
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
    @endcan

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop
