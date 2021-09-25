@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Helpdesks') }} 

@parent
@stop

{{-- Page title --}}
@section('header_right')
  

@section('header_right')
 <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">

    <div class="tab-content">

      <div class="tab-pane active" id="details">
        <div class="row">
          <div class="col-md-12">
            <div class="container row-striped">

             
            
                <div class="row">
                  <div class="col-md-4">
                    <strong>Issue</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $helpdesk ->name }}
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-4">
                    <strong>Description</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $helpdesk ->description }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <strong>Issuer</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $helpdesk ->userFirst }} {{ $helpdesk ->userLast }}
                  </div>
                </div>
      

            </div> <!-- end row-striped -->
          </div>
          </div>
        </div> <!-- end tab-pane -->


  </div>  <!-- /.col -->
</div> <!-- /.row -->

{{-- @can('update', \App\Models\Helpdesk::class)
  @include ('modals.upload-file', ['item_type' => 'license', 'item_id' => $license->id])
@endcan --}}

@stop


@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop