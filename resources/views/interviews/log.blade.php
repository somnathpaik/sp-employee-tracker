@extends('admin.layout.head')
@section('title', 'Interview Logs')
@section('content')
@include('admin.layout.header')
<div id="page-wrapper" style="min-height: 183px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">@yield('title')</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading mypnl_heading">
                        <span>@yield('title')<span>
                    </div>
                    <!-- /.panel-heading -->
                    @component('components.tables.table', ['table_data' => $interview_logs])
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th class="text-center">Interview Person</th>
                                <th class="text-center">Interview Date Time</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Update Datetime</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($interview_logs as $interview_log)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ optional($interview_log->employeeUser)->full_name }}</td>
                                <td class="text-center">{{ carbon_date_time($interview_log->date_time)->format(config('setting.date_time')) }}</td>
                                <td class="text-center">{{ $interview_log->status_text }}</td>
                                <td class="text-center">{{ $interview_log->updated_at->format(config('setting.date_time')) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center">No data found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endcomponent
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection