@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{-- {{ trans('admin/billquantities/table.view') }}  --}}
{{ trans('View bill of Material') }} 

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
    {{-- <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}</a></li> --}}

  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="details">
      <div class="row">
        <div class="col-md-12">
           <div class="container row-striped">
     
            @if ($billquantity->option)
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/billquantities/table.type') }}
                </strong>
               </div>
                <div class="col-md-8">
                {!! nl2br(e($billquantity->option)) !!}
                </div>
           </div>
           @endif

           @if ($billquantity->type)
           <div class="row">
             <div class="col-md-4">
               <strong>
                {{ trans('admin/billquantities/table.categories') }}
               </strong>
              </div>
               <div class="col-md-8">
               {!! nl2br(e($billquantity->type)) !!}
               </div>
          </div>
          @endif

          @if ($billquantity->brand)
          <div class="row">
            <div class="col-md-4">
              <strong>
               {{ trans('admin/billquantities/table.brand') }}
              </strong>
             </div>
              <div class="col-md-8">
              {!! nl2br(e($billquantity->brand)) !!}
              </div>
         </div>
         @endif

            @if ($billquantity->modelNo)
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/billquantities/table.modelNo.') }}
                </strong>
               </div>
                <div class="col-md-8">
                {!! nl2br(e($billquantity->modelNo)) !!}
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

            @if ($billquantity->sale_value)
            <div class="row">
              <div class="col-md-4">
                <strong>
                 {{ trans('admin/billquantities/form.sale_value') }}
                </strong>
               </div>
                <div class="col-md-8">
                  RM {{ \App\Helpers\Helper::formatCurrencyOutput($billquantity->sale_value) }}
                {{-- {!! nl2br(e($billquantity->sale_value)) !!} --}}
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
                RM {{ \App\Helpers\Helper::formatCurrencyOutput($billquantity->buy_value) }}
               {{-- {!! nl2br(e($billquantity->buy_value)) !!} --}}
               </div>
          </div>
          @endif

          @if ($billquantity->filename)
           <div class="row">
             <div class="col-md-4">
               <strong>
                {{ trans('Download ') }}
               </strong>
              </div>
               <div class="col-md-8">
                {{-- {{ \App\Helpers\Helper::formatCurrencyOutput($billquantity->filename) }} --}}
                <a href="{{ url('/') }}/bom-file-download/?file={{$billquantity->filename}}">Download</a>
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
