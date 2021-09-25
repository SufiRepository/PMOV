{{-- @extends('layouts/default')

@section('title')
{{ trans('admin/projects/general.view') }}
 - {{ $project[0]->name }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
      
                <table class="table table-striped snipe-table"
                
              data-search="true"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              >
                    <thead>
                        <tr>
                          <td>ID</td>
                          <td>Name</td>
                          <td>Detail</td>
                          
                          <td colspan="2">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskslisted as $show)
                        <tr>
                            <td>{{$show->id}}</td>
                            <td>{{$show->name}}</td>
                            <td>{{$show->details}}</td>
                
                            <td><a href="" class="btn btn-primary">Edit</a></td>
                            <td>
                                <form action="" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
      
            </div><!-- /.box-body -->
      
            <div class="box-footer clearfix">
            </div>
          </div><!-- /.box -->
        </div>
      </div>

      @section('moar_scripts')
      @include ('partials.bootstrap-table')
      @stop

@stop --}}

@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/projects/general.view') }}
 - {{ $project[0]->name }}
@parent
@stop

{{-- @section('header_right')
  @can('create', \App\Models\Task::class)
  <a href="{{ route('Tasks.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop --}}

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <table
                data-columns="{{ \App\Presenters\TaskPresenter::dataTableLayout() }}"
                data-cookie-id-table="tasksTable"
                data-pagination="true"
                data-id-table="tasksTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                data-toolbar="#toolbar"
                id="tasksTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.tasks.index') }}"
                data-export-options='{
                "fileName": "export-tasks-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
        </table>

      </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'Tasks-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\TaskPresenter::dataTableLayout()])
@stop