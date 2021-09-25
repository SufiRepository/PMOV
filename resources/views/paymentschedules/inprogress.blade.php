@extends('layouts/default')

{{-- Page title --}}
@section('title')
Payment / Billing
@parent
@stop

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('datatables/datatables.min.css') }}"/>
  
@endpush

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ route('projectsreroute',['projectid'=> $projects]) }}" class="btn btn-primary">
    {{ trans('general.back') }}</a>
</div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

  {{--  view payment / col start --}}
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
    <a href="" data-toggle="tab">
    <div class="small-box bg-purple">
      <div class="inner">
        <p>Total Payment <br> RM {{$totalpayment}}</p>
      </div>
      <a href="{{ route('viewpayment',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> View Payment</a>
    </div>
  </div><!-- ./col -->

  {{--  view billing / col start --}}
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
    <a href="" data-toggle="tab">
    <div class="small-box bg-green">
      <div class="inner">
        <p>Total Billing <br> RM {{$totalbilling}}</p>
      </div>
      <a href="{{ route('viewbilling',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> View Billing</a>
    </div>
  </div><!-- ./col end -->

  <div class="col-lg-2 col-xs-3">
    <a href="{{ route('createbilling',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> Billing</a>
    <a href="{{ route('createpayment',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> Payment</a>

  </div><!-- ./col end -->
</div>

{{-- end add --}}


<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
   
    <li class="active" ><a href="#projects" data-toggle="tab">Tasks</a></li>
    
 
    <li><a href="#paymentschedules" data-toggle="tab">Payment</a></li>
    
    
    <li><a href="#billings" data-toggle="tab">Billing</a></li>
    
    
  </ul>

  <div class="tab-content">
    
    <div class="tab-pane active" id="projects">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
      
                <table
                    data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
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
                    data-url="{{ route('api.tasks.index') }}"
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
    
    <div class="tab-pane" id="paymentschedules">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
      
                <table
                    data-columns="{{ \App\Presenters\PaymentschedulePresenter::dataTableLayout() }}"
                    data-cookie-id-table="paymentTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="paymentTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.paymentschedules.index') }}"
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

    <div class="tab-pane" id="billings">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
      
                <table
                    data-columns="{{ \App\Presenters\BillingPresenter::dataTableLayout() }}"
                    data-cookie-id-table="billingTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="billingTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.billings.index') }}"
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



  <div>
</div><!-- end tabs custom  -->





@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop
