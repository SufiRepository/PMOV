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
                    data-cookie-id-table="filesTable"
                    data-pagination="true"
                    data-id-table="filesTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="filesTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.projectuploads.index', ['file_id' => $file->id]) }}"
                    data-export-options='{
                    "fileName": "export-files-{{ str_slug($file->name) }}-users-{{ date('Y-m-d') }}",
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
