@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $team->name }}
 {{ trans('general.team') }}
 @if ($team->model_number!='')
     ({{ $team->model_number }})
 @endif

@parent
@stop

{{-- Right header --}}
@section('header_right')
    @can('manage', \App\Models\Team::class)
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
                    data-columns="{{ \App\Presenters\TeamPresenter::dataTableLayout() }}"
                    data-cookie-id-table="usersTable"
                    data-pagination="true"
                    data-id-table="usersTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="usersTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.teams.index', ['team_id' => $team->id]) }}"
                    data-export-options='{
                    "fileName": "export-teams-{{ str_slug($team->name) }}-users-{{ date('Y-m-d') }}",
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
