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
    @can('manage', \App\Models\TaskFile::class)
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
                    data-columns="{{ \App\Presenters\TaskFilePresenter::dataTableLayout() }}"
                    data-cookie-id-table="taskfilesTable"
                    data-pagination="true"
                    data-id-table="taskfilesTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="taskfilesTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.projectuploads.index', ['taskfile_id' => $taskfile->id]) }}"
                    data-export-options='{
                    "fileName": "export-tasksfiles-{{ str_slug($taskfile->name) }}-users-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
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