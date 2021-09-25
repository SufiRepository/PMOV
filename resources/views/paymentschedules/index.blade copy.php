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
<div class="row">
      

      <div class="col">
        
        {{-- <div class="content">
          <div class="clearfix">
            <h2>Payment</h2>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active" ><a href="#payment" data-toggle="tab">Payment</a></li>
                <li><a href="#billing" data-toggle="tab">Billing</a></li>
              </ul>
            </div>
          </div> --}}
      
          <div class="tab-content box box-primary">
              <div class="box-body">
                  <div class="tab-pane active" id="payment">
                    <table  class="display nowrap" style="width:100%" id="myTable">
                      <thead>
                        <tr>
                          <th>ID</th>
                          {{-- <th>Main/Sub</th> --}}
                          <th>Task</th>
                          <th>Amount</th>
                          <th>Payment schedule</th>
                          <th>Contractor/Supplier</th>
                          <th>Action</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $i = 1;
                        @endphp

                        @foreach ($tasks as $task)
                        @if ($task->billingOrpayment == NULL)
                              @continue
                        @endif

                        @if ($task->payment != NULL)
                              @continue
                        @endif
                        <tr>
                            {{-- <td>{{ $task->id}}</td> --}}
                            <td>{{ $i++ }}</td>
                            {{-- <td>Main task</td> --}}
                            <td>{{ $task->name}}</td>
                            <td>{{ $task->amount_task}}</td>
                            <td>{{ $task->payment_schedule_date}}</td>
                            <td>{{ $task->contractorName}}</td>
                            @if ($task->billingOrpayment == 'payment')
                              <td><a class="btn btn-primary" href="{{ route('newpayment',['id'=> $task->id]) }}">Payment</a></td>
                            @else
                              <td><a class="btn btn-primary" href="{{ route('newbilling',['id'=> $task->id]) }}">Billing</a></td>
                            @endif
                            
                          </tr>
                          
                        @endforeach

                        {{--  --}}
                        @foreach ($subtasks as $subtask)
                        @if ($subtask->billingOrpayment == NULL)
                               @continue
                        @endif
                        @if ($subtask->payment != NULL)
                                @continue
                        @endif
                        <tr>
                            {{-- <td>{{ $subtask->id}}</td> --}}

                            <td>{{ $i++ }}</td>
                            
                            {{-- <td>Subtask</td> --}}
                            <td>{{ $subtask->name}}</td>
                            <td>{{ $subtask->amount_task}}</td>
                            <td>{{ $subtask->payment_schedule_date}}</td>
                            <td>{{ $subtask->contractorName}}</td>
                            @if ($subtask->billingOrpayment == 'payment')
                              <td><a class="btn btn-primary" href="{{ route('newpaymentsub',['id'=> $subtask->id]) }}">Payment</a></td>
                            @else
                              <td><a class="btn btn-primary" href="{{ route('newbillingsub',['id'=> $subtask->id]) }}">Billing</a></td>
                            @endif
                            
                          </tr>
                         
                        @endforeach
                        
                        {{--  --}}
  
                        
  
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
        </div>
      </div>
</div>

@stop

{{-- @section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'Tasks-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\TaskPresenter::dataTableLayout()])
@stop --}}

@push('js')
  <script type="text/javascript" src="{{ URL::asset('datatables/datatables.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('datatables/moment.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('datatables/datetime-moment.js') }}"></script>

  <script>
    $(document).ready( function () {
      $.fn.dataTable.moment( 'dddd, MMMM Do, YYYY' );

      $('#myTable').DataTable({
        
        dom: 'Bfrtip',
        buttons: [
          'colvis','copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "scrollX": true
      });

    } );
  </script>
  
@endpush

