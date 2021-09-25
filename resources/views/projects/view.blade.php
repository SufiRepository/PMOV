@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{$project->name}}
 {{-- (Role ID : {{$role_id}}) --}}
@parent
@stop



{{-- Right header --}}
@section('header_right')
<div class="btn-group pull-right">
  <a href="{{ route('projects.index') }}" class="btn btn-primary pull-right">{{ trans('general.back') }}</a>

  @can('update', $project)
            <a   type="button" class="btn btn-primary pull-right "  href="{{ route('projects.edit', ['project' => $project->id]) }}">
               <i class="fa fa-pencil-square" aria-hidden="true"></i>{{ trans('admin/projects/general.edit') }}</a>
          @endcan
</div>
@stop

{{-- Page content --}}
@section('content')
   
<div class="row">
  
{{-- project --}}
  <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    @can('index', \App\Models\Task::class)
      {{-- <a href="{{ route('projects.index') }}"> --}}
      <div class="small-box bg-green">
        <div class="inner">
          <h3> {{ number_format($counts['taskcompleted']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('admin/projects/general.completedtask') }}</p>
        </div>
        {{-- <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div> --}}
      </div>
    @endcan
  </div><!-- ./col -->


  {{-- project --}}
  <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    @can('index', \App\Models\Task::class)
      {{-- <a href="{{ route('projects.index') }}"> --}}
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3> {{ number_format($counts['delayed']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('admin/projects/general.delaytask') }}</p>
        </div>
        {{-- <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div> --}}
      </div>
    @endcan
  </div><!-- ./col -->


  {{-- project --}}
  <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    @can('index', \App\Models\Task::class)
      {{-- <a href="{{ route('projects.index') }}"> --}}
      <div class="small-box bg-purple">
        <div class="inner">
          <h3> {{ number_format($counts['task']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('admin/projects/general.highpriority') }}</p>
        </div>
        {{-- <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div> --}}
      </div>
    @endcan
  </div><!-- ./col -->

   {{-- project --}}
   <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    @can('index', \App\Models\Task::class)
      {{-- <a href="{{ route('projects.index') }}"> --}}
      <div class="small-box bg-blue">
        <div class="inner">
          <h3> {{ number_format($counts['total_task']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('admin/projects/general.totaltask') }}</p>
        </div>
        {{-- <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div> --}}
      </div>
    @endcan
  </div><!-- ./col -->

  {{-- project --}}
  <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    @can('index', \App\Models\Task::class)
      {{-- <a href="{{ route('projects.index') }}"> --}}
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3> {{ number_format($counts['delayed']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('admin/projects/general.delaytask') }}</p>
        </div>
        {{-- <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div> --}}
      </div>
    @endcan
  </div><!-- ./col -->

</div>


<div class="row">
  <div class="col-md-9">

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        {{-- <li class="active"><a href="#details" data-toggle="tab">Details</a></li>     --}}

        @if (is_null($project->implementationplan_id))
        @can('index', \App\Models\Implementationplan::class)
        <li class="active"><a href="#implementationplans" data-toggle="tab">{{ trans('general.implementationplans') }}</a></li>
        @endcan
        @endif

        
        @if (!is_null($project->implementationplan_id))
        @can('index', \App\Models\Task::class)
        <li class="active"><a href="#tasks" data-toggle="tab">{{ trans('general.tasks') }}</a></li>
        @endcan
        @endif


        @can('index', \App\Models\Team::class)
        <li><a href="#teams" data-toggle="tab"> {{ trans('admin/projects/general.project_members') }}</a></li>
        @endcan
         @can('index', \App\Models\Asset::class)
        <li><a href="#asset" data-toggle="tab">{{ trans('admin/projects/general.assets') }}</a></li>
        @endcan

        @can('index', \App\Models\Accessory::class)
        <li><a href="#accessory" data-toggle="tab">{{ trans('admin/projects/general.accessories') }}</a></li>
        @endcan

        @can('index', \App\Models\Consumable::class)
        <li><a href="#consumables" data-toggle="tab">{{ trans('admin/projects/general.consumables') }}</a></li>
        @endcan

        @can('index', \App\Models\License::class)
        <li><a href="#license" data-toggle="tab">{{ trans('admin/projects/general.licenses') }}</a></li>
        @endcan

        @can('index', \App\Models\BillQuantity::class)
        <li> <a href="#billquantities" data-toggle="tab">{{ trans('general.bom') }}</a></li>
        @endcan

        @can('index', \App\Models\File::class)
        <li><a href="#uploadedfiles" data-toggle="tab">{{ trans('admin/projects/general.uploadfile') }}</a></li>
        @endcan

        @can('index', \App\Models\Helpdesk::class)
        <li><a href="#helpdesk" data-toggle="tab">{{ trans('admin/projects/general.helpdesk') }}</a></li>
        @endcan
       

       
      </ul>
      
      <div class="tab-content">

        @if (!is_null($project->implementationplan_id))

        @can('index', \App\Models\Task::class)
        <div class="tab-pane active" id="tasks">
          <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listoftasks') }}</h2>
                    {{-- <div class="col-md-2" style="float:right;margin:auto;">
                      @if (!is_null($project->implementationplan_id))
                        @can('create', \App\Models\Task::class)
                        <a  type="button" class="btn btn-primary btn-sm "   href="{{route('testtask', $project->id)}}">
                          <i class="fa fa-university" aria-hidden="true"></i>
                          {{ trans('admin/tasks/general.create_maintask') }}</a>
                        @endcan

                        @can('create', \App\Models\Supplier::class)
                        @if ((!isset($hide_new)) || ($hide_new!='true'))
                            <a href='{{ route('modal.show', 'task') }}' data-toggle="modal"  data-target="#createModal" data-select='supplier_select' class="btn btn-sm btn-primary">New</a>
                        @endif
                        @endcan

                        @endif
                    </div> --}}
                  </div>
                </div><!-- /.box-header -->   
                   <div class="box">
                <div class="box-body">
                  <table
                  data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
                  data-cookie-id-table="TaskTable"
                  data-pagination="true"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  id="TaskTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.tasks.index',['project_id' => $project->id]) }}"
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
        @endif
        
        @if (is_null($project->implementationplan_id))
        @can('index', \App\Models\ImplementationPlan::class)
          <div class="tab-pane active" id="tasks">
            <div class="row">
              <div class="col-md-12">                
                  <div class="box-header with-border">
                    <div class="box-heading">
                      <h2 class="box-title"> {{ trans('general.noimplementationplan') }}</h2>
                      {{-- <div class="col-md-2" style="float:right;margin:auto;">
                        @if (is_null($project->implementationplan_id))
                        @can('create', \App\Models\ImplementationPlan::class)
                        <a  type="button" class="btn btn-primary btn-sm "   href="{{route('testimplementation', $project->id)}}">
                          <i class="fa fa-university" aria-hidden="true"></i>
                          {{ trans('admin/projects/general.create_implementationplans') }}</a>
                        @endcan
                        @endif              
                      </div> --}}
                    </div>
                  </div><!-- /.box-header --> 
                 
              </div>
  
            </div> <!--/.row-->
          </div> <!-- /.tab-pane -->
        @endcan
        @endif


       @can('index', \App\Models\Team::class)
          <div class="tab-pane" id="teams">
            <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listofteams') }}</h2>
                    {{-- <div class="col-md-2" style="float:right;margin:auto;">
                      @can('create', \App\Models\Team::class)
                      <a type="button" class="btn btn-primary btn-sm" href="{{ route('teams.create',['id' => $project->id]) }}"> 
                       <i class="fa fa-users" aria-hidden="true"></i>
                        {{ trans('admin/projects/general.new_team') }}</a>
                       @endcan
                    </div> --}}
                  </div>
                </div><!-- /.box-header -->
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
          </div>
          @endcan

          @can('index', \App\Models\File::class)
          <div class="tab-pane" id="uploadedfiles">
            <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listoffiles') }}</h2>
                    <div class="col-md-2" style="float:right;margin:auto;">
                      {{-- @can('create', \App\Models\File::class)
                      <a href="{{ route('projectuploads.create',['id' => $project->id]) }}" class="btn btn-primary btn-sm ">
                      <i class="fa fa-upload" aria-hidden="true"></i>
                      {{ trans('general.upload_file') }}</a>
                     @endcan --}}
                    </div>
                  </div>
                </div><!-- /.box-header -->

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

          @can('index', \App\Models\Asset::class)
          <div class="tab-pane " id="asset">
            <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title">{{ trans('general.listofassets') }}</h2>
                    {{-- <div class="col-md-2" style="float:right;margin:auto;">
                      @can('create', \App\Models\Asset::class)
                      <a type="button" class="btn btn-primary btn-sm " href="{{ route('hardware.create',['id' => $project->id]) }}"><i class="fa fa-building" aria-hidden="true"></i> New Asset</a>
                      @endcan
                    </div> --}}
                  </div>
                </div><!-- /.box-header -->
                <div class="box">
                  <div class="box-body">
                    <table
                      data-advanced-search="true"
                      data-click-to-select="true"
                      data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                      data-cookie-id-table="assetsListingTable"
                      data-pagination="true"
                      data-id-table="assetsListingTable"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-footer="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      data-sort-name="name"
                      data-toolbar="#toolbar"
                      id="assetsListingTable"
                      class="table table-striped snipe-table"
                      data-url="{{ route('api.assets.index',['project_id' => $project->id],
                          array('status' => e(Request::get('status')),
                          'order_number'=>e(Request::get('order_number')),
                          'company_id'=>e(Request::get('company_id')),
                          'status_id'=>e(Request::get('status_id')))) }}"
                      data-export-options='{
                      "fileName": "export{{ (Request::has('status')) ? '-'.str_slug(Request::get('status')) : '' }}-assets-{{ date('Y-m-d') }}",
                      "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
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

        @can('index', \App\Models\Accessory::class)
        <div class="tab-pane " id="accessory">
          <div class="row">
            <div class="col-md-12">
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title"> {{ trans('general.listofaccessories') }}</h2>
                  {{-- <div class="col-md-2" style="float:right;margin:auto;">
                    @can('create', \App\Models\Accessory::class)
                    <a  type="button" class="btn btn-primary btn-sm " href="{{ route('accessories.create',['id' => $project->id]) }}"> <i class="fa fa-keyboard-o" aria-hidden="true"></i> New Accessories</a>
                  @endcan  
                  </div> --}}
                </div>
              </div><!-- /.box-header -->
              <div class="box">
                <div class="box-body">
                  <table
                data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}"
                data-cookie-id-table="accessoriesTable"
                data-pagination="true"
                data-id-table="accessoriesTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-show-footer="true"
                data-sort-order="asc"
                id="accessoriesTable"
                class="table table-striped snipe-table"
                data-url="{{route('api.accessories.index',['project_id' => $project->id]) }}"
                data-export-options='{
                    "fileName": "export-accessories-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
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

      @can('index', \App\Models\Consumable::class)
        <div class="tab-pane " id="consumables">
          <div class="row">
            <div class="col-md-12">
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title">{{ trans('general.listofconsumables') }}</h2>
                  {{-- <div class="col-md-2" style="float:right;margin:auto;">
                    @can('create', \App\Models\Consumable::class)
                    <a type="button" class="btn btn-primary btn-sm " href="{{ route('consumables.create',['id' => $project->id]) }}"><i class="fa fa-fax" aria-hidden="true"></i> New Consumable</a>
                  @endcan
                  </div> --}}
                </div>
              </div><!-- /.box-header -->
              <div class="box">
                <div class="box-body">
                  <table
                  data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                  data-cookie-id-table="consumablesTable"
                  data-pagination="true"
                  data-id-table="consumablesTable"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-footer="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-sort-name="name"
                  data-toolbar="#toolbar"
                  id="consumablesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.consumables.index',['project_id' => $project->id]) }}"
                  data-export-options='{
                  "fileName": "export-consumables-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
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

        @can('index', \App\Models\License::class)
          <div class="tab-pane " id="license">
            <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listoflicenses') }}</h2>
                    {{-- <div class="col-md-2" style="float:right;margin:auto;">
                      @can('create', \App\Models\License::class)
                      <a type="button" class="btn btn-primary btn-sm " href="{{ route('licenses.create',['id' => $project->id]) }}"> <i class="fa fa-id-card-o" aria-hidden="true"></i> New License</a>
                      @endcan  
                    </div> --}}
                  </div>
                </div><!-- /.box-header -->
                <div class="box">
                  <div class="box-body">
                    <table
                    data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
                    data-cookie-id-table="licensesTable"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="licensesTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.licenses.index',['project_id' => $project->id]) }}"
                    data-export-options='{
                  "fileName": "export-licenses-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
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

          @can('index', \App\Models\BillQuantity::class)
          <div class="tab-pane " id="billquantities">
            <div class="row">
              <div class="col-md-12">
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.listofbom') }}</h2>
                    {{-- <div class="col-md-2" style="float:right;margin:auto;">
                      @can('create', \App\Models\BillQuantity::class)
                      <a href="{{ route('billquantities.create',['id' => $project->id]) }}" class="btn btn-primary btn-sm "><i class="fa fa-industry" aria-hidden="true"></i> New Bill Of Meterial</a>
                      @endcan  
                    </div> --}}
                  </div>
                </div><!-- /.box-header -->
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


        @can('index', \App\Models\BillQuantity::class)
        <div class="tab-pane " id="helpdesk">
          <div class="row">
            <div class="col-md-12">
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title"> {{ trans('general.listofhelpdesk') }}</h2>
                  {{-- <div class="col-md-2" style="float:right;margin:auto;">
                    @can('create', \App\Models\BillQuantity::class)
                    <a href="{{ route('billquantities.create',['id' => $project->id]) }}" class="btn btn-primary btn-sm "><i class="fa fa-industry" aria-hidden="true"></i> New Bill Of Meterial</a>
                    @endcan  
                  </div> --}}
                </div>
              </div><!-- /.box-header -->
              <div class="box">
                <div class="box-body">
                  <table
            data-columns="{{ \App\Presenters\HelpdeskPresenter::dataTableLayout() }}"
            data-cookie-id-table="helpdesksTable"
            data-pagination="true"
            data-id-table="helpdesksTable"
            data-search="true"
            data-show-footer="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true" 
            data-show-refresh="true"
            data-sort-order="asc"
            id="helpdesksTable"
            class="table table-striped snipe-table"
            data-url="{{route('api.helpdesks.index', ['deleted' => e(Request::get('deleted')) ]) }}"
            data-export-options='{
              "fileName": "export-helpdesks-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
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
        <h3 class="panel-title">Project Detail </h3>
      </div>
      <div class="panel-body">
       
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

              @if (!is_null($project->implementationplan))
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.projectplan') }}</strong>
                </div>
                <div class="col-md-8">
                  {{-- <a href="{{ url('/implementationplans/' . $project->implementationplan->id) }}"> {{ $project->implementationplan->name }} </a> --}}
                  {{ $project->implementationplan->name }}
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
                  Days
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

         
              {{-- new add by farez 8/6/2021 --}}

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
      </div>
    </div>

    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Project Action</h3>
      </div>
      <div class="panel-body">
      
        <div>
          @if (is_null($project->implementationplan_id))
          @can('create', \App\Models\ImplementationPlan::class)
          <a  type="button" class="btn btn-primary btn-sm "   href="{{route('testimplementation', $project->id)}}">
            <i class="fa fa-university" aria-hidden="true"></i>
            {{ trans('admin/projects/general.create_implementationplans') }}</a>
          @endcan

          @endif

          @if (!is_null($project->implementationplan_id))
          @can('create', \App\Models\Task::class)
          <a  type="button" class="btn btn-primary btn-sm "   href="{{route('testtask', $project->id)}}">
            <i class="fa fa-university" aria-hidden="true"></i>
            {{ trans('admin/tasks/general.create_maintask') }}</a>
          @endcan
          @endif
          </div>
        <br>

        <div>
          @can('create', \App\Models\Team::class)
             <a type="button" class="btn btn-primary btn-sm" href="{{ route('teams.create',['id' => $project->id]) }}"> 
              <i class="fa fa-users" aria-hidden="true"></i>{{ trans('admin/projects/general.new_team') }}</a>
          @endcan 

          @can('create', \App\Models\Asset::class)
          <a type="button" class="btn btn-primary btn-sm " href="{{ route('hardware.create',['id' => $project->id]) }}"><i class="fa fa-building" aria-hidden="true"></i> New Asset</a>
          @endcan

        </div> <br>
        <div>
          @can('create', \App\Models\License::class)
          <a type="button" class="btn btn-primary btn-sm " href="{{ route('licenses.create',['id' => $project->id]) }}"> <i class="fa fa-id-card-o" aria-hidden="true"></i>New License</a>
          @endcan  

          @can('create', \App\Models\Accessory::class)
          <a  type="button" class="btn btn-primary btn-sm " href="{{ route('accessories.create',['id' => $project->id]) }}"> <i class="fa fa-keyboard-o" aria-hidden="true"></i>New Accessories</a>
          @endcan  
      
          </div>  
          <br>  
          <div>
       
          @can('create', \App\Models\Consumable::class)
            <a type="button" class="btn btn-primary btn-sm " href="{{ route('consumables.create',['id' => $project->id]) }}"><i class="fa fa-fax" aria-hidden="true"></i> New Consumable</a>
          @endcan

          @can('create', \App\Models\BillQuantity::class)
          <a href="{{ route('billquantities.create',['id' => $project->id]) }}" class="btn btn-primary btn-sm "> <i class="fa fa-folder-open" aria-hidden="true"></i> New Bill of Material</a>
          @endcan  
          </div>
          <br>
         
         <div>         
              <a href="{{ route('openpaymentbilling',['id' => $project->id]) }}" class="btn btn-primary btn-sm "> <i class="fa fa-credit-card-alt" aria-hidden="true"></i> New Payment/Billing</a>
          @can('create', \App\Models\File::class)
              <a href="{{ route('projectuploads.create',['id' => $project->id]) }}" class="btn btn-primary btn-sm "><i class="fa fa-upload" aria-hidden="true"></i>{{ trans('general.new_upload_file') }}</a>
          @endcan
          </div> 
        <br>

        <div>  
           @can('create', \App\Models\Helpdesk::class)
        <a type="button" class="btn btn-primary btn-sm " href="{{route('createIssue', $project->id)}}"> <i class="fa fa-id-card-o" aria-hidden="true"></i>New Issue</a>
         @endcan 
        </div>
      <br>

      
      
        </div> 
       
    </div>

    

  </div>
</div>

@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop