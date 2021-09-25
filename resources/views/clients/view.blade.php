@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/clients/table.view') }} -
{{ $client->name }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">  {{ trans('general.back') }}</a>

@can('create', \App\Models\Client::class)
<a href="{{ route('clients.edit', $client->id) }}" class="btn btn-default pull-right"> {{ trans('admin/clients/table.update') }}</a>
@endcan  

@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="row">
      <div class="col-md-12">  
          <div class="box">
            <div class="box-header with-border">
              <div class="box-heading">
                <h2 class="box-title"> {{ trans('general.listofproject') }}</h2>
              </div>
               </div><!-- /.box-header -->  
              <div class="box-body">
                  <table
                  data-columns="{{ \App\Presenters\ProjectPresenter::dataTableLayout() }}"
                  data-cookie-id-table="projectTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="projectsTable"
        
                          class="table table-striped snipe-table"
                          data-url="{{route('api.projects.index', ['client_id' => $client->id])}}"
                          data-export-options='{
                              "fileName": "export-clients-{{ str_slug($client->name) }}-projects-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
        
                  </table>
              </div><!-- /.box-body -->
             <div class="box-footer clearfix">
          </div>
        </div><!-- /.box -->
      </div>
    </div> <!--/.row-->
 </div>

  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"> Detail</h3>
      </div>
      <div class="panel-body">

        
        @if ($client->name)
        <div class="row">
          <div class="col-md-4">
            <strong>
             {{ trans('admin/clients/form.to_name') }}
            </strong>
           </div>
            <div class="col-md-8">
            {!! nl2br(e($client->name)) !!}
            </div>
       </div>
       @endif

       @if ($client->contact)
       <div class="row">
         <div class="col-md-4">
           <strong>
            {{ trans('admin/clients/form.contact') }}
           </strong>
          </div>
           <div class="col-md-8">
           {!! nl2br(e($client->contact)) !!}
           </div>
      </div>
      @endif

      @if ($client->phone)
      <div class="row">
        <div class="col-md-4">
          <strong>
           {{ trans('admin/clients/form.phone') }}
          </strong>
         </div>
          <div class="col-md-8">
          {!! nl2br(e($client->phone)) !!}
          </div>
     </div>
     @endif

     @if ($client->fax)
     <div class="row">
       <div class="col-md-4">
         <strong>
          {{ trans('admin/clients/form.fax') }}
         </strong>
        </div>
         <div class="col-md-8">
         {!! nl2br(e($client->fax)) !!}
         </div>
    </div>
    @endif


    @if ($client->email)
    <div class="row">
      <div class="col-md-4">
        <strong>
         {{ trans('admin/clients/form.email') }}
        </strong>
       </div>
        <div class="col-md-8">
        {!! nl2br(e($client->email)) !!}
        </div>
   </div>
   @endif

   @if ($client->url)
   <div class="row">
     <div class="col-md-4">
       <strong>
        {{ trans('admin/clients/form.url') }}
       </strong>
      </div>
       <div class="col-md-8">
         <a href="{{ $client->url }}" target="_new">{{ $client->url }}</a>
       </div>
  </div>
  @endif

  @if ($client->address)
  <div class="row">
    <div class="col-md-4">
      <strong>
       {{ trans('admin/clients/form.address') }}
      </strong>
     </div>
      <div class="col-md-8">
       {{ $client->address }}

       @if ($client->address2)
       <br>
       {{ $client->address2 }}
       @endif
       @if (($client->city) || ($client->state))
       <br>
       {{ $client->city }} {{ strtoupper($client->state) }} {{ $client->zip }} {{ strtoupper($client->country) }}
       @endif
     </li>
      </div>
 </div>
 @endif

 @if ($client->notes)
 <div class="row">
   <div class="col-md-4">
     <strong>
      {{ trans('admin/clients/form.notes') }}
     </strong>
    </div>
     <div class="col-md-8">
     {!! nl2br(e($client->notes)) !!}
     </div>
</div>
@endif


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
