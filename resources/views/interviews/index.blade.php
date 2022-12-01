@extends('admin.layout.head')
@section('title', 'Interviews')
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
        <div class="row">
            <div class="col-lg-3">
                <a class="btn btn-info mb-20" href="{{ route('interview.create') }}" class="active">
                    <i class="fa fa-plus fa-fw"></i>
                    <i class="fa fa-book fa-fw"></i>
                    Add Interview
                </a>
            </div>
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
                    @component('components.tables.table', ['table_data' => $interviews])
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">Sr. No.</th>
                                <th class="text-center">User</th>
                                <th class="text-center">Date Time</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($interviews as $interview)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $interview->user->full_name }}</td>
                                <td class="text-center">{{ carbon_date_time($interview->date_time)->format(config('setting.date_time')) }}</td>
                                <td class="text-center">{{ $interview->status_text }}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{ route('interview.edit', $interview->uuid) }}" title="Edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form id="delete-{{ $interview->uuid }}" action="{{ route('interview.destroy', $interview->uuid) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <a href="javascript:void(0);" class="delete_prompt btn btn-danger" data-id="{{ $interview->uuid }}" title="Delete">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </form>
                                    <a class="btn btn-primary" href="{{ route('interview.log', $interview->uuid) }}" title="Edit">
                                        <i class="fa fa-list" aria-hidden="true"></i> Logs
                                    </a>
                                </td>
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