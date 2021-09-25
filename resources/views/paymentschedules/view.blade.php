@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{-- <div class="p-3 mb-2 bg-success text-white">{{$implementationplan->name}}</div> --}}
  Payment/Billing
{{-- {{ trans('admin/implementationplans/form.end_date_project') }} :  {{$implementationplan->start_date}}   --}}


@parent
@stop

@section('header_right')

{{-- <a href="{{ route('projectsreroute',['projectid'=> $implementationplan->project_id]) }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>


  <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu">
    <li role="menuitem"><a href="{{ route('implementationplans.edit', ['implementationplan' => $implementationplan->id]) }}">{{ trans('admin/implementationplans/general.edit') }}</a></li>
    <li role="menuitem">  <a href="{{route('testtask', $implementationplan->id)}}">{{ trans('admin/tasks/general.create_milestones') }}</a> </li>
  </ul> --}}
@stop



@section('moar_scripts')
{{-- @include ('partials.bootstrap-table', ['exportFile' => 'task' . $implementationplan->name . '-export', 'search' => false]) --}}
@stop

<div class="row">
  <div class="col-md-9">

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
            

          </tbody>
        </table>
      </div>
  </div>
</div>
</div>


<div class="col-md-3">

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"> Action </h3>
    </div>
    <div class="panel-body">
    
    </div>
  </div>



</div>

@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop