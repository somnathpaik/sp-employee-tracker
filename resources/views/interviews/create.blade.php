@extends('admin.layout.head')
@section('title', 'Add Interview')
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
                                <form role="form" action="{{ route('interview.store') }}" method="post">
                                    @csrf
                                    <div class="fo rm-group">
                                        <div class="row">
                                            <div class="col-lg-4 form-group">

                                                <label>User <span class="text-danger">*</span></label>
                                                <select name="user_id" class="form-control select2_dropdown" required>
                                                    <option value="">Choose User</option>
                                                    @forelse ($users as $user)
                                                    <option value="{{ $user->id }}" @if($user->id == old('user_id')) selected @endif>
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
                                                <input type="text" name="date_time" class="form-control date_time_picker" value="{{ old('date_time') }}" required onkeydown="return false;">
                                                @error('date_time')
                                                <p class="alert alert-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Choose status</option>
                                                    @forelse (\App\Models\Interview::STATUS_ARRAY as $key => $value)
                                                    <option value="{{ $key }}" @if($key==old('status')) selected @endif>
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

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection