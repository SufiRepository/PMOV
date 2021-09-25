@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/suppliers/table.view') }} -
{{ $supplier->name }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">  {{ trans('general.back') }}</a>

@can('create', \App\Models\Supplier::class)
  <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-default pull-right">
  {{ trans('admin/suppliers/table.update') }}</a>
@endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row" > 
  <div class="col-md-9">

  <div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li  class="active" ><a href="#tasks" data-toggle="tab">  {{ trans('admin/suppliers/form.tasks') }}</a></li>
    <li><a href="#subtasks" data-toggle="tab">  {{ trans('admin/suppliers/form.subtasks') }}</a></li>

  </ul>

  <div class="tab-content">

  @can('index', \App\Models\Task::class)
  <div class="tab-pane active" id="tasks">
    <div class="row">
      <div class="col-md-12">
        <div class="box-header with-border">
          <div class="box-heading">
            <h2 class="box-title"> {{ trans('general.listoftasks') }}</h2>
          </div>
        </div><!-- /.box-header -->
        <div class="box">
          <div class="box-body">
            
            <table
            data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
            data-cookie-id-table="taskTable"
            data-pagination="true"
            data-search="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true"
            data-show-footer="true"
            data-show-refresh="true"
            data-sort-order="asc"
            data-sort-name="name"
            id="taskTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.tasks.index',['supplier_id' => $supplier->id]) }}"
            data-export-options='{
          "fileName": "export-tasks-{{ date('Y-m-d') }}",
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
@endcan

@can('index', \App\Models\Subtask::class)
<div class="tab-pane" id="subtasks">
  <div class="row">
    <div class="col-md-12">
      <div class="box-header with-border">
        <div class="box-heading">
          <h2 class="box-title"> {{ trans('general.listofsubtasks') }}</h2>
        </div>
      </div><!-- /.box-header -->
      <div class="box">
        <div class="box-body">
          <table
          data-columns="{{ \App\Presenters\SubtaskPresenter::dataTableLayout() }}"
          data-cookie-id-table="subtaskTable"
          data-pagination="true"
          data-search="true"
          data-side-pagination="server"
          data-show-columns="true"
          data-show-export="true"
          data-show-footer="true"
          data-show-refresh="true"
          data-sort-order="asc"
          data-sort-name="name"
          id="subtaskTable"
          class="table table-striped snipe-table"
          data-url="{{ route('api.subtasks.index',['supplier_id' => $supplier->id]) }}"
          data-export-options='{
        "fileName": "export-subtasks-{{ date('Y-m-d') }}",
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
@endcan


  </div>
</div>

  </div>

  <div class="col-md-3">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"> Detail</h3>
    </div>
    <div class="panel-body">


  @if ($supplier->name)
  <div class="row">
    <div class="col-md-4">
      <strong>
       {{ trans('admin/suppliers/form.to_name') }}
      </strong>
     </div>
      <div class="col-md-8">
      {!! nl2br(e($supplier->name)) !!}
      </div>
 </div>
 @endif

 @if ($supplier->contact)
 <div class="row">
   <div class="col-md-4">
     <strong>
      {{ trans('admin/suppliers/form.contact') }}
     </strong>
    </div>
     <div class="col-md-8">
     {!! nl2br(e($supplier->contact)) !!}
     </div>
</div>
@endif

@if ($supplier->phone)
<div class="row">
  <div class="col-md-4">
    <strong>
     {{ trans('admin/suppliers/form.phone') }}
    </strong>
   </div>
    <div class="col-md-8">
    {!! nl2br(e($supplier->phone)) !!}
    </div>
</div>
@endif

@if ($supplier->fax)
<div class="row">
 <div class="col-md-4">
   <strong>
    {{ trans('admin/suppliers/form.fax') }}
   </strong>
  </div>
   <div class="col-md-8">
   {!! nl2br(e($supplier->fax)) !!}
   </div>
</div>
@endif


@if ($supplier->email)
<div class="row">
<div class="col-md-4">
  <strong>
   {{ trans('admin/suppliers/form.email') }}
  </strong>
 </div>
  <div class="col-md-8">
  {!! nl2br(e($supplier->email)) !!}
  </div>
</div>
@endif

@if ($supplier->url)
<div class="row">
<div class="col-md-4">
 <strong>
  {{ trans('admin/suppliers/form.url') }}
 </strong>
</div>
 <div class="col-md-8">
 {{-- {!! nl2br(e($supplier->url)) !!} --}}
 <a href="{{ $supplier->url }}" target="_new">{{ $supplier->url }}</a>

 </div>
</div>
@endif

@if ($supplier->address)
<div class="row">
<div class="col-md-4">
<strong>
 {{ trans('admin/suppliers/form.address') }}
</strong>
</div>
<div class="col-md-8">
 {{ $supplier->address }}

 @if ($supplier->address2)
 <br>
 {{ $supplier->address2 }}
 @endif
 @if (($supplier->city) || ($supplier->state))
 <br>
 {{ $supplier->city }} {{ strtoupper($supplier->state) }} {{ $supplier->zip }} {{ strtoupper($supplier->country) }}
 @endif
</li>
</div>
</div>
@endif

@if ($supplier->notes)
<div class="row">
<div class="col-md-4">
<strong>
{{ trans('admin/suppliers/form.notes') }}
</strong>
</div>
<div class="col-md-8">
{!! nl2br(e($supplier->notes)) !!}
</div>
</div>
@endif
</div>
</div>
</div>
</div>



  <!-- side address column -->
  {{-- <div class="col-md-3">

    @if (($supplier->state!='') && ($supplier->country!='') && (config('services.google.maps_api_key')))
      <div class="col-md-12 text-center" style="padding-bottom: 20px;">
        <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($supplier->address.','.$supplier->city.' '.$supplier->state.' '.$supplier->country.' '.$supplier->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
      </div>
    @endif


    <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px; padding-top: 20px;">
      @if ($supplier->contact)
      <li><i class="fa fa-user" aria-hidden="true"></i> {{ $supplier->contact }}</li>
      @endif

      @if ($supplier->phone)
      <li><i class="fa fa-phone"></i>
        <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
      </li>
      @endif

      @if ($supplier->fax)
      <li><i class="fa fa-print"></i> {{ $supplier->fax }}</li>
      @endif

      @if ($supplier->email)
      <li>
        <i class="fa fa-envelope-o"></i>
        <a href="mailto:{{ $supplier->email }}">
        {{ $supplier->email }}
        </a>
      </li>
      @endif

      @if ($supplier->url)
      <li>
        <i class="fa fa-globe"></i>
        <a href="{{ $supplier->url }}" target="_new">{{ $supplier->url }}</a>
      </li>
      @endif

      @if ($supplier->address)
      <li><br>
        {{ $supplier->address }}

        @if ($supplier->address2)
        <br>
        {{ $supplier->address2 }}
        @endif
        @if (($supplier->city) || ($supplier->state))
        <br>
        {{ $supplier->city }} {{ strtoupper($supplier->state) }} {{ $supplier->zip }} {{ strtoupper($supplier->country) }}
        @endif
      </li>
      @endif

      @if ($supplier->notes)
      <li><i class="fa fa-comment"></i> {{ $supplier->notes }}</li>
      @endif

    </ul>
      @if ($supplier->image!='')
        <div class="col-md-12 text-center" style="padding-bottom: 20px;">
          <img src="{{ Storage::disk('public')->url(app('suppliers_upload_url').e($supplier->image)) }}" class="img-responsive img-thumbnail" alt="{{ $supplier->name }}">
        </div>
      @endif

  </div> <!--/col-md-3--> --}}




@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table', [
      'showFooter' => true,
      ])
@stop
