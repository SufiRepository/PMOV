@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/billquantities/table.view') }} -
{{ $billquantity->name }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">  {{ trans('general.back') }}</a>

@can('create', \App\Models\BillQuantity::class)
<a href="{{ route('billquantities.edit', $billquantity->id) }}" class="btn btn-default pull-right"> {{ trans('admin/billquantities/table.update') }}</a>
@endcan  

@stop

{{-- Page content --}}
@section('content')


<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="details">
      <div class="row">
        <div class="col-md-12">
           <div class="container row-striped">
     
            @if ($billquantity->name)
             <div class="row">
               <div class="col-md-4">
                 <strong>
                  {{ trans('admin/billquantities/table.description') }}
                 </strong>
                </div>
                 <div class="col-md-8">
                 {!! nl2br(e($billquantity->name)) !!}
                 </div>
            </div>
            @endif

            @if ($billquantity->serial)
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/billquantities/table.serial_No') }}
                </strong>
               </div>
                <div class="col-md-8">
                {!! nl2br(e($billquantity->serial)) !!}
                </div>
           </div>
           @endif

           @if ($billquantity->type)
           <div class="row">
             <div class="col-md-4">
               <strong>
                {{ trans('admin/billquantities/form.type') }}
               </strong>
              </div>
               <div class="col-md-8">
               {!! nl2br(e($billquantity->type)) !!}
               </div>
          </div>
          @endif

            @if ($billquantity->sale_value)
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/billquantities/form.sale_value') }}
                </strong>
               </div>
                <div class="col-md-8">
                {!! nl2br(e($billquantity->sale_value)) !!}
                </div>
           </div>
           @endif

           @if ($billquantity->buy_value)
           <div class="row">
             <div class="col-md-4">
               <strong>
                {{ trans('admin/billquantities/form.buy_value') }}
               </strong>
              </div>
               <div class="col-md-8">
               {!! nl2br(e($billquantity->buy_value)) !!}
               </div>
          </div>
          @endif

          @if ($billquantity->net_profit)
          <div class="row">
            <div class="col-md-4">
              <strong>
               {{ trans('admin/billquantities/form.net_profit') }}
              </strong>
             </div>
              <div class="col-md-8">
              {!! nl2br(e($billquantity->net_profit)) !!}
              </div>
         </div>
         @endif

           </div>
        </div>
      </div>
    </div>

  </div>
</div>


@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table', [
      'showFooter' => true,
      ])
@stop
