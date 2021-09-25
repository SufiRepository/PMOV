@extends('layouts/default')

{{-- Page title --}}
@section('title')

{{ trans('admin/billings/general.view') }}
- {{$billing->name}}

@parent
@stop

@section('header_right')

<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>


  <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu">
    <li role="menuitem">  <a   href="{{ route('billings.create',['id' => $billing->id]) }}">Crete Sub Task</a>
    </li>

    <li role="menuitem"><a href="{{ route('billings.edit', ['billing' => $billing->id]) }}">{{ trans('admin/projects/general.edit') }}</a></li>

    {{-- <li role="menuitem"><a href="{{ route('clone/project', $project->id) }}">{{ trans('admin/projects/general.clone') }}</a></li> --}}
</ul>

@stop


{{-- Page content --}}
@section('content')

<div class="row">

  {{--  view total contractor on project --}}
<div class="col-lg-2 col-xs-3">
  <!-- small box -->

    <a href="#billings" data-toggle="tab">
  <div class="small-box bg-purple">
    
    <div class="inner">
      {{-- <h3> {{ number_format($counts['assignwork']) }}</h3> --}}
      <h3> 0 </h3>
        <p>{{ trans('general.billing') }}</p>
    </div>

    <div class="icon" aria-hidden="true">
      <i class="fa fa-industry" aria-hidden="true"></i>
    </div>
    {{-- @can('index', \App\Models\AssignWork::class) --}}
    <div class="dropdown">
      <a href="#billings" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">
        {{ trans('general.moreinfo') }}
      </a>
    </div>
      {{-- <a href="{{ route('assignworks.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a> --}}
    {{-- @endcan --}}
    <a href="{{ route('billings.create',['id' => $billing->id]) }}" class="btn btn-danger btn-sm btn-block">
      {{ trans('general.create') }}
    </a>
  </div>

  
</div><!-- ./col -->

{{-- added by fikri --}}
<div class="col-lg-2 col-xs-3">
  <!-- small box -->

    <a href="#billings" data-toggle="tab">
  <div class="small-box bg-orange">
    
    <div class="inner">
      {{-- <h3> {{ number_format($counts['assignwork']) }}</h3> --}}
      <h3> 0 </h3>
        <p>{{ trans('general.billing') }}</p>
    </div>

    <div class="icon" aria-hidden="true">
      <i class="fa fa-upload" aria-hidden="true"></i>
    </div>
    {{-- @can('index', \App\Models\AssignWork::class) --}}
    <div class="dropdown">
      <a href="#billings" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">
        {{ trans('general.moreinfo') }}
      </a>
    </div>
      {{-- <a href="{{ route('assignworks.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a> --}}
    {{-- @endcan --}}
    {{-- <a href="{{ route('upload',['id' => $billing->id]) }}" class="btn btn-danger btn-sm btn-block">
      {{ trans('general.create') }}
    </a> --}}
  </div>

  
</div><!-- ./col -->
</div>

<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
    <li><a href="#billings" data-toggle="tab">{{ trans('admin/billings/form.billings') }}</a></li>
    
  </ul>

  <div class="tab-content">

    <div class="tab-pane active" id="details">
      <div class="row">
        <div class="col-md-12">
          <div class="container row-striped">


            @if ($billing->name)
             <div class="row">
               <div class="col-md-4">
                 <strong>
                  {{ trans('admin/billings/form.to_name') }}
                 </strong>
                </div>
                 <div class="col-md-8">
                 {!! nl2br(e($billing->name)) !!}
                 </div>
            </div>
            @endif

            

            @if (!is_null($billing->user))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.user') }}</strong>
              </div>
              <div class="col-md-8">
                {{-- <a href="{{ url('/user/' . $project->user->id) }}"> {{ $project->user->username }} </a> --}}
                {{ $billing->user->username }}
              </div>
            </div>
          @endif
      
      
          @if ($billing->actual_costing > 0)
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('general.actual_costing') }}
              </strong>
            </div>
            <div class="col-md-8">
              {{ $snipeSettings->default_currency }}
              {{ \App\Helpers\Helper::formatCurrencyOutput($billing->actual_costing) }}
            </div>
          </div>
          @endif
      
          @if ($billing->expected_costing > 0)
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('general.expected_costing') }}
              </strong>
            </div>
            <div class="col-md-8">
              {{ $snipeSettings->default_currency }}
              {{ \App\Helpers\Helper::formatCurrencyOutput($billing->expected_costing) }}
            </div>
          </div>
          @endif
      
      {{-- end add --}}
      
            @if ($billing->start_date)
              <div class="row">
                <div class="col-md-4">
                  <strong>
                    {{ trans('admin/billings/form.start_date') }}
                  </strong>
                </div>
                <div class="col-md-8">
                  {{ \App\Helpers\Helper::getFormattedDateObject($billing->start_date, 'date', false) }}
                </div>
              </div>
            @endif
            
            @if (isset($billing->due_date))
            <div class="row">
              <div class="col-md-4">
                <strong>
                  {{ trans('admin/billings/form.due_date') }}
                </strong>
              </div>
              <div class="col-md-8">
                {{ \App\Helpers\Helper::getFormattedDateObject($billing->due_date, 'date', false) }}
              </div>
            </div>
            @endif
      
      
              @if ($billing->details)
              <div class="row">
                <div class="col-md-4">
                  <strong>
                    {{ trans('general.details') }}
                  </strong>
                </div>
                <div class="col-md-8">
                  {!! nl2br(e($billing->details)) !!}
                </div>
              </div>
              @endif
      

          </div>
        </div>
      </div>
    </div>


    <div class="tab-pane" id="billings">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
      
              <table
              data-columns="{{ \App\Presenters\BillingPresenter::dataTableLayout() }}"
              data-cookie-id-table="billingTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="billingTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.billings.index',['billing_id' => $billing->id]) }}"
              data-export-options='{
            "fileName": "export-projects-{{ date('Y-m-d') }}",
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

    {{-- <div class="tab-pane" id="uploadedfile">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
      
              <table
              data-columns="{{ \App\Presenters\FilePresenter::dataTableLayout() }}"
              data-cookie-id-table="FileTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="fileTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.files.index',['billing_id' => $billing->id]) }}"
              data-export-options='{
            "fileName": "export-projects-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","icon"]
            }'>
        </table>
      
            </div><!-- /.box-body -->
      
            <div class="box-footer clearfix">
            </div>
          </div><!-- /.box -->
        </div>

      </div> <!--/.row-->
    </div> <!-- /.tab-pane --> --}}

</div>



@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'billing' . $billing->name . '-export', 'search' => false])
@stop
