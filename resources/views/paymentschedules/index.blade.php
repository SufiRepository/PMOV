@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Payment & Billing') }}
@parent
@stop

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ URL::previous() }}" class="btn btn-primary">
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
      {{-- <a href="{{ route('viewpayment',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> View Payment</a> --}}
      <a href="{{ route('createpayment',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> New Payment</a>

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
      {{-- <a href="{{ route('viewbilling',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> View Billing</a> --}}
      <a href="{{ route('createbilling',['id'=> $projects]) }}" class="btn btn-danger btn-sm btn-block"> New  Billing</a>

    </div>
  </div><!-- ./col end -->

  
      {{-- <div class="panel-heading">
        <h3 class="panel-title"> Action </h3>
      </div>
      <div class="panel-body">
      
          <a href="{{ route('createbilling',['id'=> $projects]) }}" class="btn btn-danger btn-sm "> New  Billing</a>

          <a href="{{ route('createpayment',['id'=> $projects]) }}" class="btn btn-danger btn-sm "> New Payment</a>

      </div>
     --}}

 
</div>


<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        {{-- <li class="active"><a href="#subtasks" data-toggle="tab">{{ trans('admin/subtasks/form.subtasks') }}</a></li> --}}
        <li class="active"><a href="#payment" data-toggle="tab">Payment</a></li>
        <li><a href="#billings" data-toggle="tab">Billing</a></li>
      </ul>
    
      <div class="tab-content">
    
        {{-- <div class="tab-pane active" id="subtasks">
          <div class="row">
            <div class="col-md-12">
         
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listoftasks') }}</h2>
                  </div>
                </div><!-- /.box-header -->    
                 <div class="box">
                <div class="box-body">
                  <table
                  data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
                  data-cookie-id-table="TaskTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="TaskTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.tasks.index') }}"
                  data-export-options='{
                "fileName": "export-projects-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","icon"]
                }'>
            </table>
                </div><!-- /.box-body -->
          
                <div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
    
          </div> <!--/.row-->
        </div> <!-- /.tab-pane --> --}}
    
    
    
        <div class="tab-pane active" id="payment">
          <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    {{-- <h2 class="box-title"> {{ trans('general.listoffiles') }}</h2> --}}
                  </div>
                </div><!-- /.box-header -->    
                <div class="box">
                <div class="box-body">

                  <table
                  data-columns="{{ \App\Presenters\PaymentSchedulePresenter::dataTableLayout() }}"
                  data-cookie-id-table="PaymentscheduleTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="paymentscheduleTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.paymentschedules.index') }}"
                  data-export-options='{
                "fileName": "export-payment-{{ date('d-m-y') }}",
                "ignoreColumn": ["actions","image","change","icon"]
                }'>
            </table>
          
                </div><!-- /.box-body -->
          
                <div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
    
          </div> <!--/.row-->
        </div> <!-- /.tab-pane -->
    
    
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
          
                <div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
    
          </div> <!--/.row-->
        </div> <!-- /.tab-pane -->
    
      
    </div>
    </div>
  </div>

  <div class="col-md-3">

    {{-- <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"> Action </h3>
      </div>
      <div class="panel-body">
      
          <a href="{{ route('createbilling',['id'=> $projects]) }}" class="btn btn-danger btn-sm "> New  Billing</a>

          <a href="{{ route('createpayment',['id'=> $projects]) }}" class="btn btn-danger btn-sm "> New Payment</a>

      </div>
    </div> --}}

  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'Tasks-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\TaskPresenter::dataTableLayout()])
@stop