<div>
    @if($notice)
    <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                <div class="panel-heading mypnl_heading"> 
                        <span>Your Notice</span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="fo rm-group">
                                    <div class="row">
                                        <div class="col-lg-3 form-group">
                                            <label>Notice Type</label>
                                            <div>{{ $notice->notice_type_text }}</div>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label>Notice Level</label>
                                            <div>{{ $notice->notice_level_text }}</div>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Reason of notice</label>
                                            <div>{!! $notice->reason_of_notice !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    @endif
</div>