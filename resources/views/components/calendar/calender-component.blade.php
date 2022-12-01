@push('styles')
<link href="{{asset('css/calendar.css')}}" rel="stylesheet">
@endpush
<div>
    <div id="timeslot_form" class="user login_form profile_form_design">
        <div class="calendar_design panel1">
            <div class="container-fluid">
                <div class="row">
                    <div class="span12">
                        <div class="calendar_heading">
                            <div class="row justify-content-between">
                                <div class="col-auto col-md-6">
                                    <div class="cal_arrows_head">
                                        @if(Session::get('role') == "ADMIN")
                                        <div class="cal_arrow arrow-left">
                                            <a href="javascript:void(0);" class="cld_left_arrow" data-user_id={{ $user_id }}>
                                                <i class="fa fa-angle-left"></i>
                                            </a>
                                        </div>
                                        @endif
                                        <span class="btn active btn_fonts panel1-badge current_month" id="current_month_text">{{ Carbon\Carbon::now()->format("F") }}</span>
                                        <div id="user_data" data-user_id={{ $user_id }}></div>
                                        @if(Session::get('role') == "ADMIN")
                                        <div class="cal_arrow arrow-right">
                                            <a href="javascript:void(0);" class="cld_right_arrow">
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto col-md-6 align-right">
                                    <span class="btn active btn_fonts work_hour" id="work_hour_text">Total work hours: {{ $total_work_hours }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="scroll-x">
                            <table class="table-condensed table-bordered dashboard_calendar">
                                <thead>
                                    <tr>
                                        <th>Sun</th>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                    </tr>
                                </thead>
                                <tbody class="first_panel">
                                </tbody>
                            </table>
                            <div>
                            </div>
                        </div>
                        <div class="scroll-x" style="display:none;">
                            <table class="table-condensed table-bordered dashboard_calendar">
                                <thead>
                                    <tr>
                                        <th>Sun</th>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                    </tr>
                                </thead>
                                <tbody class="second_panel">
                                </tbody>
                            </table>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
@include('components.calendar.includes.calendar_js')
@endsection