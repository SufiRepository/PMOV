@extends('layouts/default')

{{-- Page title --}}
@section('title')
View Payment
@parent
@stop

@push('css')
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('datatables/datatables.min.css') }}"/>
@endpush

@section('header_right')

<div class="btn-toolbar">
  <a href="{{ route('openpaymentbilling',['id' => $project->id]) }}" class="btn btn-primary">
    {{ trans('general.back') }}</a>
</div>
@stop

{{-- Page content --}}
@section('content')
  {{-- <section class="content-header">
      <h1 class="pull-left">Payments</h1>
      <h1 class="pull-right">
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="">Add New</a>
      </h1>
  </section> --}}
  <div class="content">
    <div class="clearfix"></div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    {{-- <th>Main/Sub</th> --}}
                    <th>Task</th>
                    <th>Contractor/Supplier</th>
                    {{-- <th>Purchase Order No</th>
                    <th>Invoice No</th>
                    <th>Payment Ref No</th> --}}
                    <th>Payment Schedule</th>
                    <th>Payment Date</th>
                    <th>Task Amount</th>
                    <th>Paid Amount</th>
                    <th>Description</th>
                    {{-- <th>Action</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach ($payments as $key => $payment)
                    <tr>
                      
                      @if($payment->task_id != NULL)
                        <td>{{ ++$key }}</td>
                        {{-- <td>Main</td> --}}
                        <td>{{ $payment->taskName}}</td>
                        
                      @elseif ($payment->subtask_id !=NULL)
                        <td>{{ ++$key }}</td>
                        {{-- <td>Sub</td> --}}
                        <td>{{ $payment->subtaskName}}</td>

                      @else
                        <td>{{ ++$key }}</td>
                        {{-- <td>Main</td> --}}
                        <td>{{ $payment->taskName}}</td>
                      @endif

                      
                      <td>{{ $payment->contractorName}}</td>
                      {{-- <td>{{ $payment->purchaseorder_no}}</td>
                      <td>{{ $payment->invoice_no}}</td>
                      <td>{{ $payment->paymentreference_no}}</td> --}}
                      <td>{{ $payment->payment_schedule_date}}</td>
                      <td>{{ $payment->paymentdate}}</td>
                      <td>{{ $payment->amount_task}}</td>
                      <td>{{ $payment->amount}}</td>
                      <td>{{ $payment->description}}</td>

                      {{-- <td>{{ $payment->paymentstatus}}</td> --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <div class="text-center">

    </div>
  </div>


@stop

@push('js')
  <script type="text/javascript" src="{{ URL::asset('datatables/datatables.min.js') }}"></script>

  <script>
    $(document).ready( function () {
      $('#myTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          'colvis','copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    } );
  </script>
  
@endpush