@extends('admin.layout.head')
@section('title', 'Edit Interview')
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
                        <span class="back_btn">
                            <a type="reset" href="{{ route('interview.index') }}">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </span>
                        <span>@yield('title')</span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('admin.include.success')
                                @include('admin.include.error')
                                <form role="form" action="{{ route('interview.update', $interview->uuid) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="fo rm-group">
                                        <div class="row">
                                            <div class="col-lg-4 form-group">
                                                <label>User <span class="text-danger">*</span></label>
                                                <select name="user_id" class="form-control select2_dropdown" required>
                                                    <option value="">Choose User</option>
                                                    @forelse ($users as $user)
                                                    <option value="{{ $user->id }}" @if($user->id == old('user_id', $interview->user_id)) selected @endif>
                                                        {{ $user->full_name }}
                                                    </option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @error('user_id')
                                                <p class="alert alert-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label>Date Time <span class="text-danger">*</span></label>
                                                <input type="text" name="date_time" class="form-control date_time_picker" value="{{ old('date_time', $interview->date_time) }}" required onkeydown="return false;">
                                                @error('date_time')
                                                <p class="alert alert-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Choose status</option>
                                                    @forelse (\App\Models\Interview::STATUS_ARRAY as $key => $value)
                                                    <option value="{{ $key }}" @if($key==old('status', $interview->status)) selected @endif>
                                                        {{ $value }}
                                                    </option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @error('status')
                                                <p class="alert alert-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info submit_info">Save</button>
                                </form>
                            </div>
                            <!-- /.col-lg-6 form-group (nested) -->
                            <!-- /.col-lg-6 form-group (nested) -->
                        </div>
                        <!-- /.row (nested) -->
                    </div>                    
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading mypnl_heading">
                        <span>Interview History<span>
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