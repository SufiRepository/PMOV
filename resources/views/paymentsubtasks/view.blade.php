@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{ trans('admin/paymentsubtasks/general.view') }}
- {{$paymentsubtask->subtask->name}}

@parent
@stop

@section('header_right')

<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="container row-striped">

            @if ($paymentsubtask->name)
             <div class="row">
               <div class="col-md-4">
                 <strong>
                  {{ trans('admin/paymentsubtasks/form.to_name') }}
                 </strong>
                </div>
                 <div class="col-md-8">
                 {!! nl2br(e($paymentsubtask->name)) !!}
                 </div>
            </div>
            @endif

            

            @if (!is_null($paymentsubtask->user))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.user') }}</strong>
              </div>
              <div class="col-md-8">
                {{-- <a href="{{ url('/user/' . $project->user->id) }}"> {{ $project->user->username }} </a> --}}
                {{ $paymentsubtask->user->username }}
              </div>
            </div>
          @endif
      
          @if (!is_null($paymentsubtask->contractor))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.contractors') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/contractors/' . $paymentsubtask->contractor->id) }}"> {{ $paymentsubtask->contractor->name }} </a>
              </div>
            </div>
          @endif

          @if (!is_null($paymentsubtask->supplier))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.suppliers') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/suppliers/' . $paymentsubtask->supplier->id) }}"> {{ $paymentsubtask->supplier->name }} </a>
              </div>
            </div>
          @endif

              @if ($paymentsubtask->details)
              <div class="row">
                <div class="col-md-4">
                  <strong>
                    {{ trans('general.details') }}
                  </strong>
                </div>
                <div class="col-md-8">
                  {!! nl2br(e($paymentsubtask->details)) !!}
                </div>
              </div>
              @endif

              @if (!is_null($paymentsubtask->purchase_order))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('Purchase Order File') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/subtaskPO-file-download/?file='. $paymentsubtask->purchase_order) }}">Download</a>
                {{-- <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a> --}}
              </div>
            </div>
          @endif

          @if (!is_null($paymentsubtask->delivery_order))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('Delivery Order File') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/subtaskDO-file-download/?file='. $paymentsubtask->delivery_order) }}">Download</a>
                {{-- <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a> --}}
              </div>
            </div>
          @endif

          @if (!is_null($paymentsubtask->supported_documents))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('Supported Document File') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/subtaskSD-file-download/?file='. $paymentsubtask->supported_documents) }}">Download</a>
                {{-- <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a> --}}
              </div>
            </div>
          @endif
      
          @if ($paymentsubtask->costing > 0)
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('admin/paymentsubtasks/form.payments') }}
              </strong>
            </div>
            <div class="col-md-8">
              {{ $snipeSettings->default_currency }}
              {{ \App\Helpers\Helper::formatCurrencyOutput($paymentsubtask->costing) }}
            </div>
          </div>
          @endif

          </div>
        </div>
      </div>
    </div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'paymentsubtask' . $paymentsubtask->name . '-export', 'search' => false])
@stop
