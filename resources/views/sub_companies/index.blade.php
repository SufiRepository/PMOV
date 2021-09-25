@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('general.sub_companies') }}
  @parent
@stop

@section('header_right')
  <a href="{{ route('sub_companies.create') }}" class="btn btn-primary pull-right">
    {{ trans('general.create') }}</a>
@stop
{{-- Page content --}}
@section('content')
  <div class="row">
    <div class="col-md-9">
      <div class="box box-default">
        <div class="box-body">
          <div class="table-responsive">

            <table
              data-columns="{{ \App\Presenters\Sub_CompanyPresenter::dataTableLayout() }}"
              data-cookie-id-table="sub_companiesTable"
              data-pagination="true"
              data-id-table="sub_companiesTable"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-refresh="true"
              data-sort-order="asc"
              id="sub_companiesTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.sub_companies.index') }}"
              data-export-options='{
                        "fileName": "export-sub_companies-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>

            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- side address column -->
    <div class="col-md-3">
      <h2>About Companies</h2>
      <p>
        n the corporate world, a subsidiary is a company that belongs to another company, which is usually referred to as the parent company or the holding company      </p>
  </div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
