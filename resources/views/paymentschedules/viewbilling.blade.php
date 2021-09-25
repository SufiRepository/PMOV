@extends('layouts/default')

{{-- Page title --}}
@section('title')
View Billing
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
 
  <div class="content">
    <div class="clearfix"></div>

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
              <table class="table" id="myTable">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Task</th>
                    {{-- <th>Invoice No</th>
                    <th>Delivery No</th>
                    <th>Payment No</th> --}}
                    <th>Payment Schedule</th>
                    <th>Billing Date</th>
                    <th>Task Amount</th>
                    <th>Bill Amount</th>
                    <th>Description</th>
                    {{-- <th>Billing Status</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach ($billings as $billing)
                    <tr>
                      <td>{{ $billing->id}}</td>
                      <td>{{ $billing->name}}</td>
                      {{-- <td>{{ $billing->invoice_no}}</td>
                      <td>{{ $billing->deliveryorder_no}}</td>
                      <td>{{ $billing->payment_no}}</td> --}}
                      <td>{{ $billing->payment_schedule_date}}</td>
                      <td>{{ $billing->billingdate}}</td>
                      <td>{{ $billing->amount_task}}</td>
                      <td>{{ $billing->amount}}</td>
                      <td>{{ $billing->description}}</td>
                      {{-- <td>{{ $billing->billingstatus}}</td> --}}
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