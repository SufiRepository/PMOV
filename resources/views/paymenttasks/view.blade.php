@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{ trans('admin/paymenttasks/general.view') }}
- {{$paymenttask->task->name}}

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

            @if ($paymenttask->name)
             <div class="row">
               <div class="col-md-4">
                 <strong>
                  {{ trans('admin/paymenttasks/form.to_name') }}
                 </strong>
                </div>
                 <div class="col-md-8">
                 {!! nl2br(e($paymenttask->name)) !!}
                 </div>
            </div>
            @endif

            @if ($paymenttask->task)
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/paymenttasks/form.tasks') }}
                </strong>
               </div>
                <div class="col-md-8">
                  <a href="{{ url('/tasks/' . $paymenttask->task->id) }}"> {{ $paymenttask->task->name }} </a>

                {{-- {!! nl2br(e($paymenttask->task->task)) !!} --}}
                </div>
           </div>
           @endif

           @if (is_null($paymenttask->task))
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/paymenttasks/form.contacrtor') }}
                </strong>
               </div>
                <div class="col-md-8">
                {!! nl2br(e($paymenttask->task->contractor_id)) !!}
                </div>
           </div>
           @endif

           @if (is_null($paymenttask->task))
           <div class="row">
             <div class="col-md-4">
               <strong>
                {{ trans('admin/paymenttasks/form.supplier') }}
               </strong>
              </div>
               <div class="col-md-8">
               {!! nl2br(e($paymenttask->task->supplier_id)) !!}
               </div>
          </div>
          @endif

           @if (!is_null($paymenttask->created_at))
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/paymenttasks/form.paymentdate') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {{ \App\Helpers\Helper::getFormattedDateObject($paymenttask->created_at, 'date', false) }}
                  </div>
                </div>
              @endif

              {{-- @if ($paymenttask->user)
              <div class="row">
                <div class="col-md-4">
                  <strong>
                   {{ trans('admin/paymenttasks/form.task') }}
                  </strong>
                 </div>
                  <div class="col-md-8">
                  {!! nl2br(e($paymenttask->task->name)) !!}
                  </div>
             </div>
             @endif --}}
  

            @if (!is_null($paymenttask->user))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('admin/paymenttasks/form.makebypayment') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/user/' . $paymenttask->user->id) }}"> {{ $paymenttask->user->username }} </a>
                {{-- {{ $paymenttask->user->name }} --}}
              </div>
            </div>
          @endif
      
      
          @if ($paymenttask->costing > 0)
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('admin/paymenttasks/form.payments') }}
              </strong>
            </div>
            <div class="col-md-8">
              {{ $snipeSettings->default_currency }}
              {{ \App\Helpers\Helper::formatCurrencyOutput($paymenttask->costing) }}
            </div>
          </div>
          @endif
      
          @if (!is_null($paymenttask->contractor))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.contractors') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/contractors/' . $paymenttask->contractor->id) }}"> {{ $paymenttask->contractor->name }} </a>
              </div>
            </div>
          @endif

          @if (!is_null($paymenttask->supplier))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.suppliers') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a>
              </div>
            </div>
          @endif

              @if ($paymenttask->details)
              <div class="row">
                <div class="col-md-4">
                  <strong>
                    {{ trans('general.details') }}
                  </strong>
                </div>
                <div class="col-md-8">
                  {!! nl2br(e($paymenttask->details)) !!}
                </div>
              </div>
              @endif

              @if (!is_null($paymenttask->purchase_order))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('Purchase Order File') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/po-file-download/?file='. $paymenttask->purchase_order) }}">Download</a>
                {{-- <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a> --}}
              </div>
            </div>
          @endif

          @if (!is_null($paymenttask->delivery_order))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('Delivery Order File') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/do-file-download/?file='. $paymenttask->delivery_order) }}">Download</a>
                {{-- <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a> --}}
              </div>
            </div>
          @endif

          @if (!is_null($paymenttask->supported_documents))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('Supported Document File') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/sd-file-download/?file='. $paymenttask->supported_documents) }}">Download</a>
                {{-- <a href="{{ url('/suppliers/' . $paymenttask->supplier->id) }}"> {{ $paymenttask->supplier->name }} </a> --}}
              </div>
            </div>
          @endif
      

          </div>
        </div>
      </div>
    </div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'paymenttask' . $paymenttask->name . '-export', 'search' => false])
@stop
