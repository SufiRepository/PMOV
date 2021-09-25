@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.dashboard') }}

- {{ $user->username }}
Copyright © {{ date('Y-m-d H:i:s') }}


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
{{-- admin sahaja boleh tengok --}}


  {{-- add by farez 18/5 --}}
{{-- project --}}
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
      <a href="{{ route('projects.index') }}">
    <div class="small-box bg-green">
      <div class="inner">
        <h3> {{ number_format($counts['project']) }}</h3>
        {{-- <h3> 0 </h3> --}}
          <p>{{ trans('general.total_project') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
        <i class="fa fa-tasks"></i>
      </div>
      @can('index', \App\Models\Project::class)
        <a href="{{ route('projects.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->
{{-- client --}}
  <div class="col-lg-2 col-xs-3">
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
      @can('index', \App\Models\Client::class)
        <a href="{{ route('clients.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->

{{-- contractor --}}
  <div class="col-lg-2 col-xs-3">
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
      @can('index', \App\Models\Contractor::class)
        <a href="{{ route('contractors.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->
 
{{-- supplier --}}
  <div class="col-lg-2 col-xs-3">
    <!-- small box -->
      <a href="{{ route('suppliers.index') }}">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3> {{ number_format($counts['supplier']) }}</h3>
        {{-- <h3> 0 </h3> --}}
          <p>{{ trans('general.total_suppliers') }}</p>
      </div>
      <div class="icon" aria-hidden="true">
        <i class="fa fa-id-card-o" aria-hidden="true"></i>
      </div>
      @can('index', \App\Models\Supplier::class)
        <a href="{{ route('suppliers.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->
  {{-- untuk end kan if super user tak dapat tengok  --}}
  @endif 

{{-- end add --}}
</div>

{{ $chartData }}
<div id="piechart" style="width: 900px; height: 500px;"></div>
<br>

@if ($counts['grand_total'] == 0)

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
    </div>

@else

<!-- recent activity -->
<div class="row">
  <div class="col-md-12">
    <div class="box">
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
    </div><!-- /.box -->
  </div>

</div> <!--/row--> 
<div class="row">
    
    {{-- <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('general.assets') }} by Status</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                        <span class="sr-only">Collapse</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-responsive">
                            <canvas id="statusPieChart" height="216"></canvas>
                        </div> <!-- ./chart-responsive -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div> --}}
    {{-- <div class="col-md-6">

        <!-- Categories -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h2 class="box-title">Asset {{ trans('general.categories') }}</h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                        <span class="sr-only">Collapse</span>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table
                                data-cookie-id-table="dashCategorySummary"
                                data-height="400"
                                data-pagination="true"
                                data-side-pagination="server"
                                data-sort-order="desc"
                                data-sort-field="assets_count"
                                id="dashCategorySummary"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.categories.index', ['sort' => 'assets_count', 'order' => 'asc']) }}">

                            <thead>
                            <tr>
                                <th class="col-sm-3" data-visible="true" data-field="name" data-formatter="categoriesLinkFormatter" data-sortable="true">{{ trans('general.name') }}</th>
                                <th class="col-sm-3" data-visible="true" data-field="category_type" data-sortable="true">
                                    {{ trans('general.type') }}
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="assets_count" data-sortable="true">
                                    <i class="fa fa-barcode" aria-hidden="true"></i>
                                    <span class="sr-only">Asset Count</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="accessories_count" data-sortable="true">
                                    <i class="fa fa-keyboard-o" aria-hidden="true"></i>
                                    <span class="sr-only">Accessories Count</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="consumables_count" data-sortable="true">
                                    <i class="fa fa-tint" aria-hidden="true"></i>
                                    <span class="sr-only">Consumables Count</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="components_count" data-sortable="true">
                                    <i class="fa fa-hdd-o" aria-hidden="true"></i>
                                    <span class="sr-only">Components Count</span>
                                </th>
                                <th class="col-sm-1" data-visible="true" data-field="licenses_count" data-sortable="true">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    <span class="sr-only">Licenses Count</span>
                                </th>
                            </tr>
                            </thead>
                        </table>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-12 text-center" style="padding-top: 10px;">
                        <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm" style="width: 100%">{{ trans('general.viewall') }}</a>
                    </div>
                </div> <!-- /.row -->

            </div><!-- /.box-body -->
        </div> <!-- /.box -->
    </div> --}}
</div>

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
@endpush

@push('css')
  
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'statustask_id'],
          

        ]);
        var options = {
          title: 'Status Milestone'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
@endpush
