@extends('admin.layout.head')
@section('title')
ClickUp Report
@endsection
@section('content')
@include('admin.layout.header')
Toast::message('message', 'level', 'title');
<div id="page-wrapper" style="min-height: 183px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Team Progress Report</h1>
            </div>

        </div>
        @if(Session::get('role')=="ADMIN")
        <div class="row">
            <div class="col-lg-12">
                <div class="pull-left btn  mb-20">
                    <form action="{{ route('team-progress-report', get_team_id()) }}" method="GET" role="search" autocomplete="off" class="form-inline">
                        <select class="form-control" name="year_search" id="year_search" required="">
                            <option value="">Choose year</option>
                            @forelse($work_years as $work_year)
                            <option value="{{ $work_year->year_value }}" {{ $work_year->year_value == $year ? 'selected' : '' }}>{{ $work_year->year_value }}</option>
                            @empty
                            <p>No data Found</p>
                            @endforelse
                        </select>
                        <button type="submit" class="btn btn-info btn-default">Search</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading mypnl_heading">
                        <span>Team Progress Report</span>
                    </div>
                    <!-- /.panel-heading -->
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">Services / Hours</th>
                                @for ($i = 1; $i <= 12; $i++) <th class="text-center" width="7%">{{ date("F", mktime(0, 0, 0, $i, 10)) }}</th>
                                    @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($report as $year => $month_data)
                            <tr>
                                <td class="text-center">{{ $year }}</td>
                                @forelse ($month_data as $work_data)
                                @if($work_data['is_month_completed'])
                                <td class="text-center @if($work_data['is_profit']) bg-success @else bg-danger @endif">
                                    <a href="javascript:void(0);" data-toggle="tooltip" title="{{ $work_data['profit_n_loss_percentage'] }}">
                                        {{ $work_data['service_n_hours'] }}
                                        @if ($work_data['is_profit'])
                                        <i class='fa fa-arrow-up'></i>
                                        @else
                                        <i class='fa fa-arrow-down'></i>
                                        @endif
                                    </a>
                                </td>
                                @else
                                <td></td>
                                @endif
                                @empty
                                <td colspan="100%" class="text-center">There are no data.</td>
                                @endforelse
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center">There are no data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading mypnl_heading">
                        <span>Team Progress of {{ $year }}</span>
                    </div>
                    <!-- /.panel-heading -->
                    <!-- /.panel-body -->
                    <div id="chartContainer"></div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!--end model-->
@endsection
@push('styles')
<style>
    .canvasjs-chart-credit {
        display: none;
    }
</style>
@endpush
@push('custom_scripts')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light1",
            title: {
                text: "Team Progress of {{ $year }}"
            },
            data: [{
                    type: "line",
                    name: "Services Hours",
                    indexLabelFontSize: 16,
                    showInLegend: true,
                    dataPoints: [
                        @forelse($graph_report_service_hours as $month => $graph_data) {
                            'label': "<?php echo $graph_data['x']; ?>",
                            y: <?php echo $graph_data['y']; ?>
                        },
                        @empty {
                            x: 0,
                            y: 0
                        }
                        @endforelse
                    ]
                },
                {
                    type: "line",
                    name: "Services Count",
                    indexLabelFontSize: 16,
                    showInLegend: true,
                    dataPoints: [
                        @forelse($graph_report_service_count as $month => $graph_data) {
                            'label': "<?php echo $graph_data['x']; ?>",
                            y: <?php echo $graph_data['y']; ?>
                        },
                        @empty {
                            x: 0,
                            y: 0
                        }
                        @endforelse
                    ]
                }
            ],
            axisY: {
                suffix: " Hours"
            }
        });
        chart.render();
    }
</script>
@endpush