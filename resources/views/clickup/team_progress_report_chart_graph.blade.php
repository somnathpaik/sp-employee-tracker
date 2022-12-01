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
                                <th class="text-center" width="10%">Clients / Services / Hours</th>
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
                                    <a href="javascript:void(0);" title="{!! strip_tags($work_data['profit_n_loss_percentage']) !!}">
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
                    <div class="col-lg-4">
                        <div>
                            <canvas id="myChartClientCount" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <canvas id="myChartServiceCount" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <canvas id="myChartHours" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4">
                        <div>
                            <canvas id="myChartJoiningCount" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <canvas id="myChartResignationCount" height="200"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
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
@push('custom_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = [<?php echo '"' . implode('","',  $month_names) . '"' ?>];
    Chart.defaults.global = '';
    const myChartHours = new Chart(
        document.getElementById('myChartHours'),
        config_hours = {
            type: 'line',
            data: data_hours = {
                labels: labels,
                datasets: [{
                    label: 'Team progress 2022 (Hours)',
                    backgroundColor: 'darkseagreen',
                    borderColor: 'darkseagreen',
                    data: [<?php echo '"' . implode('","',  $graph_report_service_hours) . '"' ?>],
                }]
            },
            options: {}
        }
    );

    const myChartServiceCount = new Chart(
        document.getElementById('myChartServiceCount'),
        config_service_count = {
            type: 'line',
            data: data_service_count = {
                labels: labels,
                datasets: [{
                    label: 'Team progress 2022 (Services)',
                    backgroundColor: 'olive',
                    borderColor: 'olive',
                    data: [<?php echo '"' . implode('","',  $graph_report_service_count) . '"' ?>],
                }]
            },
            options: {}
        }
    );

    const myChartClientCount = new Chart(
        document.getElementById('myChartClientCount'),
        config_client_count = {
            type: 'line',
            data: data_client_count = {
                labels: labels,
                datasets: [{
                    label: 'Team progress 2022 (Clients)',
                    backgroundColor: 'darkgreen',
                    borderColor: 'darkgreen',
                    data: [<?php echo '"' . implode('","',  $graph_report_client_count) . '"' ?>],
                }]
            },
            options: {}
        }
    );
    
    const joining_candidate_names = [<?php echo '"' . implode('","',  $joining_candidate_names_report) . '"' ?>];
    
    const myChartJoiningCount = new Chart(
        document.getElementById('myChartJoiningCount'),
        config_joining_count = {
            type: 'line',
            data: data_joining_count = {
                labels: labels,
                datasets: [{
                    label: 'Joining Candidates Count',
                    data: [<?php echo '"' . implode('","',  $joining_candidate_count_report) . '"' ?>],
                    borderColor: 'mediumseagreen',
                    backgroundColor: 'mediumseagreen',
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label1 = context.dataset.label + ': ' + context.parsed.y;
                                let label2 = joining_candidate_names[context.dataIndex];
                                return [label1, label2];
                            }
                        }
                    }
                }
            }
        }
    );

    const resignation_candidates_names = [<?php echo '"' . implode('","',  $resignation_candidate_names_report) . '"' ?>];

    const myChartResignationCount = new Chart(
        document.getElementById('myChartResignationCount'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Resignation Candidates Count',
                    backgroundColor: 'red',
                    borderColor: 'red',
                    data: [<?php echo '"' . implode('","',  $resignation_candidate_count_report) . '"' ?>],
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label1 = context.dataset.label + ': ' + context.parsed.y;
                                let label2 = resignation_candidates_names[context.dataIndex];
                                return [label1, label2];
                            }
                        }
                    }
                }
            }
        }
    );
</script>
@endpush