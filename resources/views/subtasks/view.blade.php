@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{-- {{ trans('admin/subtasks/general.view') }} --}}
{{$subtask->name}}


@parent
@stop

@section('header_right')

<a href="{{ route('tasksreroute',['taskid'=> $subtask->task_id]) }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>

  <a href="{{ route('subtasks.edit', ['subtask' => $subtask->id]) }}" class="btn btn-primary pull-right">
    <i class="fa fa-pencil-square" aria-hidden="true"></i>{{ trans('admin/subtasks/general.edit') }} </a>

  {{-- <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu">
    <li role="menuitem"><a href="{{ route('subtasks.edit', ['subtask' => $subtask->id]) }}">{{ trans('admin/subtasks/general.edit') }}</a></li>
</ul> --}}

@stop


{{-- Page content --}}
@section('content')

<div class="row">

</div>

<div class="row">
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
        <li class="" ><a href="#uploadedfile" data-toggle="tab">{{ trans('admin/subtasks/form.uploadfiles') }}</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-12">
               <div class="container row-striped">
         
                @if ($subtask->name)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Name') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->name)) !!}
                    </div>
               </div>
               @endif

              @if ($subtask->due_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Due Date') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->due_date)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->start_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Start Date') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->start_date)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->finish_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Finish Date') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->finish_date)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->expected_costing)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Expected Costing') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->expected_costing)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->actual_costing)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Actual Costing') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->actual_costing)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->contract_start_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Contract Start Date') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->contract_start_date)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->contract_end_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Contract End Date ') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->contract_end_date)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->contract_duration)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Duration') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->contract_duration)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->payment_schedule_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Payment Schedule') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->payment_schedule_date)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->billingOrpayment)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Billing\Payment') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->billingOrpayment)) !!}
                    </div>
               </div>
              @endif

              @if ($subtask->priority)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                     {{ trans('Priority') }}
                    </strong>
                   </div>
                    <div class="col-md-8">
                    {!! nl2br(e($subtask->priority)) !!}
                    </div>
               </div>
              @endif
               </div>
            </div>
          </div>
        
        </div>
        <div class="tab-pane" id="uploadedfile">
          <div class="row">
            <div class="col-md-12">
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title"> {{ trans('general.listoffiles') }}</h2>
                </div>
              </div><!-- /.box-header -->    
              <div class="box">
                <div class="box-body">
      
              <table
              data-columns="{{ \App\Presenters\SubtaskFilePresenter::dataTableLayout() }}"
              data-cookie-id-table="subtaskFileTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="subtaskfileTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.subtaskuploads.index',['subtask_id' => $subtask->id]) }}"
              data-export-options='{
            "fileName": "export-subtask-{{ date('Y-m-d') }}",
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

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">{{ trans('admin/subtasks/form.subtaskdetails') }} </h3>
      </div>
      <div class="panel-body">


        @if (!is_null($subtask->statustask_id) )
        <div class="row">
          <div class="col-md-4">
            <strong>{{ trans('general.statustask') }}</strong>
          </div>
          <div class="col-md-8">
            {{ $subtask->statustask_id }}
          </div>
        </div>
        @endif

        @if (!is_null($subtask->priority))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.priority') }}</strong>
        </div>
        <div class="col-md-8">
          {!! nl2br(e($subtask->priority)) !!}
        </div>
      </div>
    @endif

    {{-- @if (!is_null($subtask->statustask) && ($subtask->statustask->id == 3))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.statustask') }}</strong>
              </div>
              <div class="col-md-8">
                {{ $subtask->statustask->name }}
              </div>
            </div>
            @endif

    @if (!is_null($subtask->statustask) && ($subtask->statustask->id == 1))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.statustask') }}</strong>
        </div>
        <div class="col-md-8">
          
          {{ $subtask->statustask->name }}
        </div>
      </div>
    @endif

    @if (!is_null($subtask->statustask) && ($subtask->statustask->id == 4))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.statustask') }}</strong>
        </div>
        <div class="col-md-8">
          
          <button type="button" class="btn btn-danger">{{ $subtask->statustask->name }}</button>

          <br>
          
        </div>
      </div>
    @endif --}}

    {{-- @if (!is_null($subtask->statustask) && ($subtask->statustask->id == 5))
    <div class="row">
      <div class="col-md-4">
        <strong>{{ trans('general.statustask') }}</strong>
      </div>
      <div class="col-md-8">
        {{ $subtask->statustask->name }}
      </div>
    </div>
  @endif --}}

{{-- end add --}}

    {{-- @if (!is_null($subtask->supplier))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.supplier') }}</strong>
        </div>
        <div class="col-md-8">
          <a href="{{ url('/suplliers/' . $subtask->supplier->id) }}"> {{ $subtask->supllier->name }} </a>
        </div>
      </div>
    @endif

    @if (!is_null($subtask->contractor))
      <div class="row">
        <div class="col-md-4">
          <strong>{{ trans('general.contractors') }}</strong>
        </div>
        <div class="col-md-8">
          <a href="{{ url('/contractors/' . $subtask->contractor->id) }}"> {{ $subtask->contractor->name }} </a>
        </div>
      </div>
    @endif --}}

      @if ($subtask->contract_start_date)
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{trans('admin/subtasks/form.start_date')}}
            </strong>
          </div>
          <div class="col-md-8">
            {{ \App\Helpers\Helper::getFormattedDateObject($subtask->contract_start_date, 'date', false) }}
          </div>
        </div>
      @endif
      
      @if (isset($subtask->contract_end_date))
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('admin/subtasks/form.end_date') }}
          </strong>
        </div>
        <div class="col-md-8">
          {{ \App\Helpers\Helper::getFormattedDateObject($subtask->contract_end_date, 'date', false) }}
        </div>
      </div>
      @endif

      @if ($subtask->contract_duration)
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('admin/subtasks/form.duration') }}
          </strong>
        </div>
        <div class="col-md-8">
          {!! nl2br(e($subtask->contract_duration)) !!}  {{ trans('admin/subtasks/form.day') }}
        </div>
      </div>
      @endif


      @if ($subtask->actual_start_date)
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('general.actual_start_date') }}
            </strong>
          </div>
          <div class="col-md-8">
            {{ \App\Helpers\Helper::getFormattedDateObject($subtask->actual_start_date, 'date', false) }}
          </div>
        </div>
      @endif
      
      @if (isset($subtask->actual_end_date))
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('general.actual_end_date') }}
          </strong>
        </div>
        <div class="col-md-8">
          {{ \App\Helpers\Helper::getFormattedDateObject($subtask->actual_end_date, 'date', false) }}
        </div>
      </div>
      @endif


     

      @if ($subtask->details)
      <div class="row">
        <div class="col-md-4">
          <strong>
            {{ trans('general.details') }}
          </strong>
        </div>
        <div class="col-md-8">
          {!! nl2br(e($subtask->details)) !!}
        </div>
      </div>
      @endif

    </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Subtask Action </h3>
      </div>
      <div class="panel-body">

        @can('create', \App\Models\SubtaskFile::class)
      <a href="{{ route('subtaskuploads.create',['id' => $subtask->id]) }}" class="btn btn-primary btn-sm">
        <i class="fa fa-upload" aria-hidden="true"></i>{{ trans('admin/subtasks/form.uploadfiles') }}</a>
    @endcan

      </div>
    </div>
  </div>
</div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'subtask' . $subtask->name . '-export', 'search' => false])
@stop
