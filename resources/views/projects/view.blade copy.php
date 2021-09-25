@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{$project->name}}

{{ \App\Helpers\Helper::getFormattedDateObject($project->end_date, 'date', false) }}

@parent
@stop



{{-- Right header --}}
@section('header_right')
<div class="btn-group pull-right">
  <a href="{{ route('projects.index') }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
  @can('update', $project)
    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li role="menuitem"><a href="{{ route('projects.edit', ['project' => $project->id]) }}">{{ trans('admin/projects/general.edit') }}</a></li>
      @can('index', \App\Models\ImplementationPlan::class)
        {{-- <li role="menuitem"><a  href="{{ route('implementationplans.create',['id' => $project->id]) }}">{{ trans('admin/projects/general.create_milestone') }}</a></li> --}}
        <li role="menuitem"><a  href="{{route('testimplementation', $project->id)}}">{{ trans('admin/projects/general.create_milestone') }}</a></li>  
      @endcan
      @can('index', \App\Models\Assignwork::class)
        <li role="menuitem"><a href="{{ route('assignworks.create',['id' => $project->id]) }}"> New Assignwork </a> </li>
      @endcan
      @can('index', \App\Models\Team::class)
        <li role="menuitem"> <a  href="{{ route('teams.create',['id' => $project->id]) }}">New Team</a></li>
      @endcan
        {{-- <li role="menuitem"><a href="{{ route('clone/project', $project->id) }}">{{ trans('admin/projects/general.clone') }}</a></li> --}}
    </ul>
   @endcan
</div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

  <div class="col-lg-2 col-xs-3" style="float:right;margin:auto;">
    <div class="btn-toolbar">
      <button type="button" id="btnSubmit" class="btn btn-primary btn-sm">Submit</button>
      <button type="button" id="btnCancel" class="btn btn-primary btn-sm">Cancel</button>
      @can('create', \App\Models\File::class)
      <a href="{{ route('projectuploads.create',['id' => $project->id]) }}" class="btn btn-danger btn-sm btn-block">Upload File</a>
      @endcan


    </div>

  </div>

                  {{-- total  implementation plan  --}}
                @can('index', \App\Models\ImplementationPlan::class)
                {{-- @if($role_id === 3) --}}
                <div class="col-lg-2 col-xs-3">
                  <!-- small box -->
                    <a href="#implementationplans" data-toggle="tab">
                  <div class="small-box bg-green">
                    <div class="inner">
                        <p>{{ trans('admin/projects/general.implementationplans') }}</p>
                    </div>
                    <div class="dropdown">
                      <a href="#milestones" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">   {{ trans('general.moreinfo') }} </a>
                    </div>
                    <div class="dropdown">
                      @can('create', \App\Models\ImplementationPlan::class)
                        <a  type="button" class="btn btn-danger btn-sm btn-block"   href="{{route('testimplementation', $project->id)}}">{{ trans('admin/projects/general.create_implementationplans') }}</a>
                      @endcan
                    
                    </div>
                  </div>
                </div><!-- ./col -->
                {{-- @endif --}}
                @endcan 

                
                {{-- total  team  --}}
                @can('index', \App\Models\Team::class)
                {{-- @if($role_id === 4) --}}
                <div class="col-lg-2 col-xs-3">
                  <!-- small box -->
                    <a href="#teams" data-toggle="tab">
                  <div class="small-box bg-blue">
                    <div class="inner">
                        <p>{{ trans('Project Team') }}</p>
                    </div>
                    <div class="dropdown">
                      <a href="#teams" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">  {{ trans('general.moreinfo') }} </a>
                    </div>
                    <div class="dropdown">
                      <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Create team
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @can('create', \App\Models\Team::class)
                        <a type="button" class="dropdown-item" href="{{ route('teams.create',['id' => $project->id]) }}">Team Member</a>
                        @endcan
                      <div class="dropdown-divider"></div>
                        @can('create', \App\Models\Assignwork::class)
                        <a class="dropdown-item" href="{{ route('assignworks.create',['id' => $project->id]) }}">Team Contarctor</a>
                        @endcan  
                      </div>
                    </div>
                  </div>
                </div><!-- ./col -->
                {{-- @endif --}}
                @endcan

     {{-- total  all  --}}
     @can('index', \App\Models\Asset::class)
     {{-- {{ $role_id }} --}}
     {{-- @if($role_id === 2) --}}
     <div class="col-lg-2 col-xs-3">
      <!-- small box -->
        {{-- <a href="{{ route('consumables.index') }}"> --}}
      <div class="small-box bg-purple">
        <div class="inner">
            <p>{{ trans('general.total_assets') }}</p>
        </div>      
 {{-- to view all asset --}}
        <div class="dropdown">
          <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            More Info
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @can('index', \App\Models\Asset::class)
            <a  type="button" class="dropdown-item" href="{{ route('hardware.index',['id' => $project->id]) }}">{{ trans('general.asset') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            @endcan
            <div class="dropdown-divider"></div>
            @can('view', \App\Models\License::class)
            <a type="button"class="dropdown-item" href="{{ route('licenses.index',['id' => $project->id]) }}">{{ trans('general.licenses') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            @endcan
            <div class="dropdown-divider"></div>
            @can('index', \App\Models\Accessory::class)
            <a type="button"class="dropdown-item" href="{{ route('accessories.index',['id' => $project->id]) }}">{{ trans('general.accessories') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            @endcan
            <div class="dropdown-divider"></div>
            @can('index', \App\Models\Consumable::class)
            <a type="button" class="dropdown-item" href="{{ route('consumables.index',['id' => $project->id]) }}">{{ trans('general.consumables') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
             @endcan
          </div>
        </div>
{{-- create new --}}
        <div class="dropdown">
          <button class="btn btn-danger  btn-sm btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Create Asset
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @can('create', \App\Models\Asset::class)
            <a type="button" class="dropdown-item" href="{{ route('hardware.create',['id' => $project->id]) }}">Create Asset</a>
            @endcan
          <div class="dropdown-divider"></div>
            @can('create', \App\Models\License::class)
            <a class="dropdown-item" href="{{ route('licenses.create',['id' => $project->id]) }}">Create License</a>
            @endcan  
          <div class="dropdown-divider"></div>
          @can('create', \App\Models\Accessory::class)
            <a class="dropdown-item" href="{{ route('accessories.create',['id' => $project->id]) }}">Create Accessories</a>
          @endcan  
          <div class="dropdown-divider"></div>
          @can('create', \App\Models\Consumable::class)
            <a class="dropdown-item" href="{{ route('consumables.create',['id' => $project->id]) }}">Create Consumable</a>
          @endcan
          </div>
        </div>
      </div>
    </div><!-- ./col -->
    {{-- @endif --}}
    @endcan







{{--  view Payment --}}

<div class="col-lg-2 col-xs-3">
  <!-- small box -->
    <a href="#assignwork" data-toggle="tab">
  <div class="small-box bg-maroon">
    <div class="inner">
      {{-- <h3> 0 </h3> --}}
        <p>Payment / Billing</p>
    </div>
    <div class="dropdown">
      <a href="#assignwork" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">
        {{ trans('general.moreinfo') }}
      </a>
    </div>
    <a href="{{ route('openpaymentbilling',['id' => $project->id]) }}" class="btn btn-danger btn-sm btn-block"> Create Payment/Billing</a>
  </div>
</div><!-- ./col -->

{{-- total  implementation plan  --}}
@can('index', \App\Models\BillQuantity::class)
{{-- @if($role_id === 3) --}}
<div class="col-lg-2 col-xs-3">
 <!-- small box -->
   <a href="#billquantities" data-toggle="tab">
 <div class="small-box bg-teal">
   <div class="inner">
       <p>{{ trans('admin/projects/general.billquantities') }}</p>
   </div>
    <div class="dropdown">
     <a href="#billquantities" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">   {{ trans('general.moreinfo') }} </a>
   </div>
   <div class="dropdown">
     @can('create', \App\Models\BillQuantity::class)
     {{-- <a type="button" class="dropdown-item" href="{{ route('billquantities.create',['id' => $project->id]) }}">{{ trans('admin/projects/general.create_billquantities') }}</a> --}}
     <a href="{{ route('billquantities.create',['id' => $project->id]) }}" class="btn btn-danger btn-sm btn-block"> Create BQ</a>

       {{-- <a  type="button" class="btn btn-danger btn-sm btn-block"   href="{{route('billquantities.create', $project->id)}}">{{ trans('admin/projects/general.create_billquantities') }}</a> --}}
     @endcan
   
   </div>
 </div>
</div><!-- ./col -->
{{-- @endif --}}
@endcan 

{{-- added by fikri --}}
<div class="col-lg-2 col-xs-3">
  <a href="#uploadedfiles" data-toggle="tab">
<div class="small-box bg-orange">
  <div class="inner">
      <p>Upload File</p>
  </div>
  <div class="dropdown">
    <a href="#uploadedfiles" data-toggle="tab" class="btn btn-danger  btn-sm btn-block ">
      {{ trans('general.moreinfo') }}
    </a>
  </div>
  @can('create', \App\Models\File::class)
    <a href="{{ route('projectuploads.create',['id' => $project->id]) }}" class="btn btn-danger btn-sm btn-block">Upload File</a>
  @endcan
</div>
</div><!-- ./col -->

</div>

    <div class="row">
      <div class="col-md-12">
        <div class="container row-striped">

          @if ($project->name)
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('admin/projects/form.to_name') }}
              </strong>
            </div>
            <div class="col-md-8">
              {!! nl2br(e($project->name)) !!}
            </div>
          </div>
          @endif
        
          @if (!is_null($project->projectnumber))
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('admin/projects/form.projectnumber') }}
              </strong>
            </div>
            <div class="col-md-8">
              {!! nl2br(e($project->projectnumber)) !!}
            </div>
          </div>
          @endif

          @if (!is_null($project->start_date))
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('admin/projects/form.start_date') }}
              </strong>
            </div>
            <div class="col-md-8">
              {{ \App\Helpers\Helper::getFormattedDateObject($project->start_date, 'date', false) }}
            </div>
          </div>
        @endif
        
        @if (!is_null($project->implementationplan))
        <div class="row">
          <div class="col-md-4">
            <strong>{{ trans('general.implementationplans') }}</strong>
          </div>
          <div class="col-md-8">
            <a href="{{ url('/implementationplans/' . $project->implementationplan->id) }}"> {{ $project->implementationplan->name }} </a>
          </div>
        </div>
      @endif

      @if (!is_null($project->end_date))
       <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('admin/projects/form.end_date') }}
            </strong>
          </div>
          <div class="col-md-8">
            {{ \App\Helpers\Helper::getFormattedDateObject($project->end_date, 'date', false) }}
          </div>
        </div>
        @endif
        
        @if (!is_null($project->duration))
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('admin/projects/form.duration') }}
            </strong>
          </div>
          <div class="col-md-8">
            {!! nl2br(e($project->duration)) !!}
          </div>
        </div>
        @endif

        @if (!is_null($project->finish_date))
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('admin/projects/form.finish_date') }}
              </strong>
            </div>
            <div class="col-md-8">
              {{ \App\Helpers\Helper::getFormattedDateObject($project->finish_date, 'date', false) }}
            </div>
          </div>
        @endif

        @if ($project->value > 0)
        <div class="row">
          <div class="col-md-4">
            <strong>
              {{ trans('general.value') }}
            </strong>
          </div>
          <div class="col-md-8">
            {{ $snipeSettings->default_currency }}
            {{ \App\Helpers\Helper::formatCurrencyOutput($project->value) }}
          </div>
        </div>
        @endif
        
          @if (!is_null($project->details))
          <div class="row">
            <div class="col-md-4">
              <strong>
                {{ trans('general.details') }}
              </strong>
            </div>
            <div class="col-md-8">
              {!! nl2br(e($project->details)) !!}
            </div>
          </div>
          @endif

          @if (!is_null($project->typeproject))
          <div class="row">
            <div class="col-md-4">
              <strong>{{ trans('general.typeprojects') }}</strong>
            </div>
            <div class="col-md-8">
              <a href="{{ url('/typeprojects/' . $project->typeproject->id) }}"> {{ $project->typeproject->name }} </a>
            </div>
          </div>
        @endif

        @if (!is_null($project->user))
          <div class="row">
            <div class="col-md-4">
              <strong>{{ trans('general.project_manager') }}</strong>
            </div>
            <div class="col-md-8">
              {{-- <a href="{{ url('/user/' . $project->user->id) }}"> {{ $project->user->username }} </a> --}}
              {{ $project->user->username }}
            </div>
          </div>
        @endif

         @if (!is_null($project->company))
            <div class="row">
              <div class="col-md-4">
                <strong>{{ trans('general.company') }}</strong>
              </div>
              <div class="col-md-8">
                <a href="{{ url('/companies/' . $project->company->id) }}">{{ $project->company->name }}</a>
              </div>
            </div>
        @endif

         

        @if (!is_null($project->client))
        <div class="row">
          <div class="col-md-4">
            <strong>{{ trans('general.client') }}</strong>
          </div>
          <div class="col-md-8">
            <a href="{{ url('/clients/' . $project->client->id) }}"> {{ $project->client->name }} </a>
          </div>
        </div>
      @endif
      {{-- end add --}}

    
       {{-- new add by farez 28/5/2021 --}}
       @if (!is_null($project->location))
       <div class="row">
         <div class="col-md-4">
           <strong>{{ trans('general.location') }}</strong>
         </div>
         <div class="col-md-8">
           <a href="{{ url('/locations/' . $project->location->id) }}"> {{ $project->location->name }} </a>
         </div>
       </div>
     @endif
    {{-- end add --}}
        </div> <!-- end row-striped -->
      </div>
      </div>

      <br> 

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        {{-- <li class="active"><a href="#details" data-toggle="tab">Details</a></li>     --}}
        @can('index', \App\Models\Task::class)
        <li class="active"><a href="#implementationplans" data-toggle="tab">{{ trans('general.implementationplans') }}</a></li>
        @endcan

        @can('create', \App\Models\Team::class)
        <li><a href="#teams" data-toggle="tab">{{ trans('admin/teams/form.teams') }}</a></li>
        @endcan
        @can('create', \App\Models\BillQuantity::class)
        <li><a href="#billquantities" data-toggle="tab">{{ trans('general.billquantities') }}</a></li>
        @endcan
        @can('create', \App\Models\File::class)
        <li><a href="#uploadedfiles" data-toggle="tab">Upload File</a></li>
        @endcan
       
      </ul>
      
      <div class="tab-content">

        @can('index', \App\Models\ImplementationPlan::class)
          <div class="tab-pane active" id="implementationplans">
            <div class="row">
            
              <div class="col-md-12">
                <h3 class="text-center">  List Of Implementation Plan</h3>
                <div class="box">   
                  <div class="box-body">
                   
                    <table
                    data-columns="{{ \App\Presenters\ImplementationPlanPresenter::dataTableLayout() }}"
                    data-cookie-id-table="implementationplanTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="implementationplanTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.implementationplans.index',['project_id' => $project->id]) }}"
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
        @endcan
        
       @can('index', \App\Models\Team::class)
          <div class="tab-pane" id="teams">
            team member
            <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-body">
                    <table
                    data-columns="{{ \App\Presenters\TeamPresenter::dataTableLayout() }}"
                    data-cookie-id-table="teamTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="teamsTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.teams.index',['project_id' => $project->id]) }}"
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
            </div><!-- /.box -->
            
            {{-- team contractor
            <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-body">

                    <table
                    data-columns="{{ \App\Presenters\AssignworkPresenter::dataTableLayout() }}"
                    data-cookie-id-table="assignworkTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="assignworksTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.assignworks.index',['project_id' => $project->id]) }}"
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
            </div><!-- /.box --> --}}
          </div>
          @endcan

          @can('index', \App\Models\File::class)
          <div class="tab-pane" id="uploadedfiles">
            <div class="row">
              <div class="col-md-12">
                <h3 class="text-center">  List Of File </h3>

                <div class="box">
                  <div class="box-body">
                    <table
                    data-columns="{{ \App\Presenters\FilePresenter::dataTableLayout() }}"
                    data-cookie-id-table="uploadedfileTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="uploadedfilesTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.projectuploads.index',['project_id' => $project->id]) }}"
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
            </div><!-- /.box -->
          </div>
          @endcan


          @can('index', \App\Models\BillQuantity::class)
          <div class="tab-pane " id="billquantities">
            <div class="row">
              <div class="col-md-12">
                <h3 class="text-center">  List  Of Bill Of Quantity </h3>
                <div class="box">
                  <div class="box-body">
                    <table
                    data-columns="{{ \App\Presenters\BillQuantityPresenter::dataTableLayout() }}"
                    data-cookie-id-table="billquantityplanTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="billquantityplanTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.billquantities.index',['project_id' => $project->id]) }}"
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
        @endcan

      </div>
    </div>
@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop