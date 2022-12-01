@extends('admin.layout.head')
@section('title', 'Update Notice')
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
                            <a type="reset" href="{{ route('notice-management.index') }}">
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
                                <form role="form" action="{{ route('notice-management.update', $notice->uuid) }}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="fo rm-group">
                                        <div class="row">
                                            <div class="col-lg-4 form-group">

                                                <label>User <span class="text-danger">*</span></label>
                                                <select name="user_id" class="form-control select2_dropdown" required>
                                                <option value="">Choose User</option>
                                                @forelse ($users as $user)
                                                    <option value="{{ $user->id }}" @if($user->id == old('user_id', $notice->user->id)) selected @endif>
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
                                                <label>Notice Type <span class="text-danger">*</span></label>
                                                <select name="notice_type" class="form-control" required>
                                                <option value="">Choose Notice Type</option>
                                                <option value="{{ \App\Models\NoticeManagement::NOTICE_TYPE_CLIENT }}" @if(\App\Models\NoticeManagement::NOTICE_TYPE_CLIENT == old('notice_tye', $notice->notice_type)) selected @endif>
                                                    Client
                                                </option>
                                                <option value="{{ \App\Models\NoticeManagement::NOTICE_TYPE_INTERNAL }}" @if(\App\Models\NoticeManagement::NOTICE_TYPE_INTERNAL == old('notice_tye', $notice->notice_type)) selected @endif>
                                                    Internal
                                                </option>
                                                </select>
                                                @error('notice_type')
                                                <p class="alert alert-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label>Notice Level <span class="text-danger">*</span></label>
                                                <select name="notice_level" class="form-control" required>
                                                <option value="">Choose Notice Level</option>
                                                <option value="{{ \App\Models\NoticeManagement::NOTICE_LEVEL_SOFT }}" @if(\App\Models\NoticeManagement::NOTICE_LEVEL_SOFT == old('notice_level', $notice->notice_level)) selected @endif>
                                                    Soft
                                                </option>
                                                <option value="{{ \App\Models\NoticeManagement::NOTICE_LEVEL_HARD }}" @if(\App\Models\NoticeManagement::NOTICE_LEVEL_HARD == old('notice_level', $notice->notice_level)) selected @endif>
                                                    Hard
                                                </option>
                                                <option value="{{ \App\Models\NoticeManagement::NOTICE_LEVEL_NOT_MANAGEABLE }}" @if(\App\Models\NoticeManagement::NOTICE_LEVEL_NOT_MANAGEABLE == old('notice_level', $notice->notice_level)) selected @endif>
                                                    Not Manageable
                                                </option>
                                                </select>
                                                @error('notice_level')
                                                <p class="alert alert-danger"> {{ $message }} </p>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12 form-group">
                                                <label>Reason of notice</label>
                                                <textarea name="reason_of_notice" class="form-control" rows="5">{{ old('reason_of_notice', $notice->reason_of_notice) }}</textarea>
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