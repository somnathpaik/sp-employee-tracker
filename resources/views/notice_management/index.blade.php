@extends('admin.layout.head')
@section('title', 'Notices')
@section('content')
@include('admin.layout.header')
<div id="page-wrapper" style="min-height: 183px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Notices</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-3">
                <a class="btn btn-info mb-20" href="{{ route('notice-management.create') }}" class="active">
                    <i class="fa fa-plus fa-fw"></i>
                    <i class="fa fa-book fa-fw"></i>
                    Add Notice
                </a>
            </div>
            @include('notice_management.includes.filter')
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.include.success')
                @include('admin.include.error')
                <div class="panel panel-default">
                    <div class="panel-heading mypnl_heading">
                        <span>@yield('title')<span>
                    </div>
                    <!-- /.panel-heading -->
                    @component('components.tables.table', ['table_data' => $notices])
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th class="text-center">User</th>
                                <th class="text-center">Notice Type</th>
                                <th class="text-center">Notice Level</th>
                                <th class="text-center">Reason of notice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notices as $notice)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $notice->user->full_name }}</td>
                                <td class="text-center">{{ $notice->notice_type_text }}</td>
                                <td class="text-center">{{ $notice->notice_level_text }}</td>
                                <td class="text-center">{!! $notice->reason_of_notice !!}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{ route('notice-management.edit', $notice->uuid) }}" title="Edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form id="delete-{{ $notice->uuid }}" action="{{ route('notice-management.destroy', $notice->uuid) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <a href="javascript:void(0);" class="delete_prompt btn btn-danger" data-id="{{ $notice->uuid }}" title="Delete">
                                            <i class="fa fa-trash"></i>Delete
                                        </a>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center">No data.</td>
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