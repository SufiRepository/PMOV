@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.dashboard') }}
- {{ $user->username }}
{{-- tambah sini --}}
@parent
@stop
{{-- Page content --}}
@section('content')

@if ($snipeSettings->dashboard_message!='')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        {!!  Parsedown::instance()->text(e($snipeSettings->dashboard_message))  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row">
  <!-- panel -->
        @if (!Auth::user()->isSuperUser()) 
{{-- admin sahaja boleh tengok --}

{{-- project --}}
  <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    
    @can('index', \App\Models\Project::class)
      <a href="{{ route('projects.index') }}">
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3> {{ number_format($counts['project']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('general.total_project') }}</p>
        </div>
        <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div>
        @can('create', \App\Models\Project::class)
        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm btn-block"> {{ trans('general.new_project') }}
        </a>
        @endcan
      </div>
    @endcan
  </div><!-- ./col -->

  {{-- task --}}
  <div class="col-lg-2 col-xs-3 ">
    <!-- small box -->
    @can('index', \App\Models\Task::class)
        <a href="{{ route('tasks.index') }}">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3> {{ number_format($counts['task']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('general.tasks') }}</p>
        </div>
        <div class="icon" aria-hidden="true">
          <i class="fa fa-tachometer" aria-hidden="true"></i>
        </div>
        @can('create', \App\Models\Task::class)
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm btn-block"> {{ trans('general.new_task') }}
        </a>
        @endcan
      </div>
    @endcan
  </div><!-- ./col -->

{{-- staff --}}
  <div class="col-lg-2 col-xs-3" style="float:right;margin:auto;">
    <!-- small box -->
    @can('view', \App\Models\User::class)
    <a href="{{ route('users.index') }}"> 
      <div class="small-box bg-green">
        <div class="inner">
          <h3> {{ number_format($counts['user']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('general.staff') }}</p>
        </div>
        <div class="icon" aria-hidden="true">
          <i class="fa fa-tasks"></i>
        </div> </a>
        
        @can('create', \App\Models\User::class)
        @if ($snipeSettings->ldap_enabled == 1)
            <a href="{{ route('ldap/user') }}" class="btn btn-primary btn-sm btn-block"><span class="fa fa-sitemap"></span> LDAP Sync</a>
        @endif
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm btn-block" style="margin-right: 5px;">  {{ trans('general.new_staff') }}</a>
    @endcan

      </div>
      @endcan
    </div><!-- ./col -->
  
  </div>

</div>
{{-- project --}}
<div class="row">
  <div class="col-md-10" style="float:left;margin:auto;">
      <div class="box">
        <div class="box-header with-border">
          <div class="box-heading">
            <h2 class="box-title"> {{ trans('general.projects') }}</h2>
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
                data-url="{{ route('api.projects.index') }}"
                data-export-options='{
              "fileName": "export-projects-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","icon"]
              }'>
            </table>
  
        </div><!-- /.box-body -->
        </div>  
        <div class="box">
          <div class="box-header with-border">
            <div class="box-heading">
              <h2 class="box-title"> {{ trans('general.tasks') }}</h2>
            </div>
          </div><!-- /.box-header -->
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
                  data-show-refresh="true"
                  data-sort-order="asc"
                  data-toolbar="#toolbar"
                  id="tasksTable"
    
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.tasks.index') }}"
                  data-export-options='{
                "fileName": "export-tasks-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","icon"]
                }' >
    
                {{-- class="table table-striped snipe-table"
                data-url="{{route('api.tasks.index', ['project_id' => $project->id])}}"
                data-export-options='{
                "fileName": "export-tasks-{{ str_slug($task->name) }}-projects-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                  }'> --}}
                
              </table>
    
          </div><!-- /.box-body -->
    
          <div class="box-footer clearfix">
          </div>
        </div><!-- /.box --> 
      </div> 
  <!-- recent activity -->
    {{-- <div class="box">
      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('general.recent_activity') }}</h2>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                <i class="fa fa-minus" aria-hidden="true"></i>
                <span class="sr-only">Collapse</span>
            </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">

                <table
                    data-cookie-id-table="dashActivityReport"
                    data-height="400"
                    data-pagination="false"
                    data-id-table="dashActivityReport"
                    data-side-pagination="server"
                    data-sort-order="desc"
                    data-sort-name="created_at"
                    id="dashActivityReport"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.activity.index', ['limit' => 25]) }}">
                    <thead>
                    <tr>
                        <th data-field="icon" data-visible="true" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"><span  class="sr-only">Icon</span></th>
                        <th class="col-sm-3" data-visible="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                        <th class="col-sm-3" data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                    </tr>
                    </thead>
                </table>
            </div><!-- /.responsive -->
          </div><!-- /.col -->
          <div class="col-md-12 text-center" style="padding-top: 10px;">
            <a href="{{ route('reports.activity') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
          </div>
        </div><!-- /.row -->
      </div><!-- ./box-body -->
    </div><!-- /.box --> --}}
  

  <div class="col-lg-2 col-xs-3" style="float:right;margin:auto;">
    <!-- small box -->
      <a href="{{ route('clients.index') }}">
    <div class="small-box bg-purple">
      <div class="inner">
        <h3> {{ number_format($counts['client']) }}</h3>
        {{-- <h3> 0 </h3> --}}
          <p>{{ trans('general.total_client') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
        <i class="fa fa-address-card" aria-hidden="true"></i>
      </div>
      @can('create', \App\Models\Client::class)
      <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm btn-block">  {{ trans('general.new_client') }}</a>
      @endcan
    </div>

    <!-- small box -->
    <a href="{{ route('contractors.index') }}">
      <div class="small-box bg-red">
        <div class="inner">
          <h3> {{ number_format($counts['contractor']) }}</h3>
          {{-- <h3> 0 </h3> --}}
            <p>{{ trans('general.total_contractors') }}</p>
        </div>
        <div class="icon" aria-hidden="true">
          <i class="fa fa-address-book" aria-hidden="true"></i>
        </div>
        @can('create', \App\Models\Contractor::class)
        <a href="{{ route('contractors.create') }}" class="btn btn-primary btn-sm btn-block">  {{ trans('general.new_contractor') }}  </a>
        @endcan
      </div>

      <a href="{{ route('suppliers.index') }}">
        <div class="small-box bg-blue">
          <div class="inner">
            <h3> {{ number_format($counts['supplier']) }}</h3>
            {{-- <h3> 0 </h3> --}}
              <p>{{ trans('general.suppliers') }}</p>
          </div>
          <div class="icon" aria-hidden="true">
            <i class="fa fa-id-card-o" aria-hidden="true"></i>
          </div>
          @can('create', \App\Models\Supplier::class)
          <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm btn-block">  {{ trans('general.new_supplier') }}</a>
          @endcan
        </div>
        @endif 

  </div><!-- ./col -->
</div>

{{-- <table class="table">
  <tbody>
    <tr>
      
      <td><div id="piechart" style="width: 500px; height: 300px;"> </div></td>
      <td><div id="piechartsubtask" style="width: 500px; height: 300px;"> </div></td>
      <td> </td>
    </tr>
  </tbody>
</table> --}}
  

<br>

@if ($counts['grand_total'] == 0)
{{-- 
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">This is your dashboard. There are many like it, but this one is yours.</h2>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>


                            <p><strong>It looks like you haven't added anything yet, so we don't have anything awesome to display. Get started by adding some assets, accessories, consumables, or licenses now!</strong></p>

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> --}}

@else


@endif
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['simple_view' => true, 'nopages' => true])
@stop

@push('js')

<script nonce="{{ csrf_token() }}">
    // ---------------------------
    // - ASSET STATUS CHART -
    // ---------------------------
      var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
      var pieChart = new Chart(pieChartCanvas);
      var ctx = document.getElementById("statusPieChart");
      var pieOptions = {
              legend: {
                  position: 'top',
                  responsive: true, 
                  maintainAspectRatio: true,
              }
          };

      $.ajax({
          type: 'GET',
          url: '{{  route('api.statuslabels.assets.bytype') }}',
          headers: {
              "X-Requested-With": 'XMLHttpRequest',
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
          },
          dataType: 'json',
          success: function (data) {
              var myPieChart = new Chart(ctx,{ 
                  type   : 'doughnut',
                  data   : data,
                  options: pieOptions
              });
          },
          error: function (data) {
             // window.location.reload(true);
          }
      });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['statustask_id', 'Task'],
          <?php echo $chartData  ?> 
           ]);
        // sss
        var options = {
          title: 'Status Main Task'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['statustask_id', 'Task'],
          <?php echo $chartDataSubtask  ?> 
           ]);
        var options = {
          title: 'Status Tasks'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechartsubtask'));
        chart.draw(data, options);
      }
    </script>


@endpush


