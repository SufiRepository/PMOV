@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{-- {{ $team->name }}
 {{ trans('general.team') }}
 @if ($team->model_number!='')
     ({{ $team->model_number }}) --}}
 @endif

@parent
@stop

{{-- Right header --}}
@section('header_right')
    @can('manage', \App\Models\File::class)
        <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              {{ trans('button.actions') }}
              <span class="caret"></span>
          </button>
          
        </div>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table table-responsive">

          <table
          data-columns="{{ \App\Presenters\FilePresenter::dataTableLayout() }}"
          data-cookie-id-table="uploadedfileTable"
          data-pagination="true"
          data-search="true"
          data-side-pagination="server"
          data-show-columns="true"
          data-show-export="true"
          data-show-footer="true"
          data-show-refresh="true"
          data-sort-order="asc"
          data-sort-name="name"
          id="uploadedfilesTable"
          class="table table-striped snipe-table"
          data-url="{{ route('api.projectuploads.index',['project_id' => $project->id]) }}"
          data-export-options='{
        "fileName": "export-projects-{{ date('Y-m-d') }}",
        "ignoreColumn": ["actions","image","change","icon"]
        }'>
    </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
