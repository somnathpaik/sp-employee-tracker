@extends('admin.layout.head')
@section('content')
@include('admin.layout.header')
Toast::message('message', 'level', 'title');
@if(Session::get('role')!="ADMIN")
@push('styles')
<link href="{{asset('css/calendar.css')}}" rel="stylesheet">
@endpush
@endif
<div id="page-wrapper" style="min-height: 183px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ ucfirst($user->name).' '.ucfirst($user->last_name) }} Reports</h1>
            </div>

        </div>
        <!-- /.col-lg-12 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <x-calendar.calender-component :userId="$user_id" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <x-calendar.year-calendar :userId="$user_id" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <x-calendar.month-year-wise-service-report :userId="$user_id" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <x-notices.user-notice :userId="$user_id" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <x-interview.log :userId="$user_id" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection