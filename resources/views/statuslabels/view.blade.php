@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $statuslabel->name }} {{ trans('general.assets') }}
    @parent
@stop

{{-- Page content --}}
@section('content')



<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li  class="active" ><a href="#implementationplans" data-toggle="tab">{{ trans('admin/implementationplans/form.implementationplans') }}</a></li>
      <li><a href="#tasks" data-toggle="tab">{{ trans('admin/tasks/form.tasks') }}</a></li>
      <li><a href="#subtasks" data-toggle="tab">{{ trans('admin/subtasks/form.subtasks') }}</a></li>
    </ul>
  
    <div class="tab-content">
  
      <div class="tab-pane active"  id="implementationplans">
        <div class="row">
            <div class="col-md-12">
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
                  data-url="{{ route('api.implementationplans.index',['status_id' => $statuslabel->id]) }}"
                  data-export-options='{
                "fileName": "export-implementationplans-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","icon"]
                }'>
            </table>
                </div><!-- /.box-body -->
                 <div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
    
          </div> <!--/.row-->
      </div>

      <div class="tab-pane" id="tasks">
        <div class="row">
            <div class="col-md-12">
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
                  data-url="{{ route('api.tasks.index',['status_id' => $statuslabel->id]) }}"
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
      </div>

      <div class="tab-pane" id="subtasks">
        <div class="row">
            <div class="col-md-12">
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
                  id="subtasksTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.subtasks.index',['status_id' => $statuslabel->id]) }}"
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
      </div>

    </div>
</div>
        
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {{ Form::open([
                      'method' => 'POST',
                      'route' => ['hardware/bulkedit'],
                      'class' => 'form-inline',
                       'id' => 'bulkForm']) }}
                    <div class="row">
                        <div class="col-md-12">
                            @if (Request::get('status')!='Deleted')
                                <div id="toolbar">
                                    <select name="bulk_actions" class="form-control select2">
                                        <option value="edit">Edit</option>
                                        <option value="delete">Delete</option>
                                        <option value="labels">Generate Labels</option>
                                    </select>
                                    <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                                </div>
                            @endif

                                <table
                                        data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                                        data-cookie-id-table="assetsListingTable"
                                        data-pagination="true"
                                        data-id-table="assetsListingTable"
                                        data-search="true"
                                        data-side-pagination="server"
                                        data-show-columns="true"
                                        data-show-export="true"
                                        data-show-refresh="true"
                                        data-sort-order="asc"
                                        id="assetsListingTable"
                                        class="table table-striped snipe-table"
                                        data-url="{{route('api.assets.index', ['status_id' => $statuslabel->id]) }}"
                                        data-export-options='{
                              "fileName": "export-assets-{{ str_slug($statuslabel->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                                </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    {{ Form::close() }}
                </div><!-- ./box-body -->
            </div><!-- /.box -->

            <div class="row">
                <div class="col-md-12">
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
                      data-url="{{ route('api.subtasks.index',['status_id' => $statuslabel->id]) }}"
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

            <div class="row">
                <div class="col-md-12">
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
                      data-url="{{ route('api.subtasks.index',['status_id' => $statuslabel->id]) }}"
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
        </div>
    </div> --}}
@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'assets-export',
        'search' => true,
        'columns' => \App\Presenters\AssetPresenter::dataTableLayout()
    ])

@stop
