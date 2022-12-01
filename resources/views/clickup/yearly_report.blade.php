@extends('admin.layout.head')
@section('title')
{{ $page_heading_and_title }}
@endsection
@section('content')
@include('admin.layout.header')
Toast::message('message', 'level', 'title');
<div id="page-wrapper" style="min-height: 183px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $page_heading_and_title }}</h1>
            </div>

        </div>
        @if(Session::get('role')=="ADMIN")
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-left btn  mb-20">
                        <form action="{{ route($route_name, get_team_id()) }}" method="GET" role="search" autocomplete="off" class="form-inline">
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
                    <span>ClickUp / Service Report</span>
                    <div class="col-lg-3 pull-right" style="margin-top: -7px;">
                        <select class="col-md-3  form-control" name="select_team" id="team" required="">
                            <option value="">--Please select for view report--</option>
                            @forelse($teams as $team)
                            <option value="{{ $team->id }}" {{ $team->id == $id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @empty
                            <p>No User Found</p>
                            @endforelse
                        </select>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center" width="1%">#</th>
                            <th class="text-center" width="9%">User / Hours</th>
                            @for ($i = 1; $i <= 12; $i++) <th class="text-center" width="7%">{{ date("F", mktime(0, 0, 0, $i, 10)) }}</th>
                                @endfor
                                <th class="text-center" width="6%">Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse($report as $user_name => $month_data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $user_name }}</td>
                                    @forelse ($month_data as $month_name => $work_data)
                                        @if($month_name == 'total_hours')
                                            <td class="text-center">{{ $work_data }}</td>
                                        @else
                                            @if($work_data['is_month_completed'])
                                                @if($work_data['is_joined'])
                                                    <td class="text-center" style="background-color: {{ $work_data['back_ground_color'] }};">
                                                        <a href="javascript:void(0);" style="color: {{ $work_data['front_color'] }};" data-toggle="tooltip" title="{{ $work_data['title'] }}">
                                                            {{ $work_data['clickup_work_hour'] }}
                                                        </a>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        {{ $work_data['clickup_work_hour'] }}
                                                    </td>
                                                @endif
                                            @else
                                                <td></td>
                                            @endif
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
</div>
<!-- /.row -->
</div>
<!--end model-->
@endsection