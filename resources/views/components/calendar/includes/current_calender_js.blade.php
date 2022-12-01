<script>
    $(document).ready(function() {
        var date_today = new Date();
        var date_backup = new Date();
        var weekday = new Array(7);
        weekday[0] = "Sunday";
        weekday[1] = "Monday";
        weekday[2] = "Tuesday";
        weekday[3] = "Wednesday";
        weekday[4] = "Thursday";
        weekday[5] = "Friday";
        weekday[6] = "Saturday";
        var monthName = new Array(12);
        monthName[0] = ["January", 31];
        monthName[1] = ["February", 28];
        monthName[2] = ["March", 31];
        monthName[3] = ["April", 30];
        monthName[4] = ["May", 31];
        monthName[5] = ["June", 30];
        monthName[6] = ["July", 31];
        monthName[7] = ["August", 31];
        monthName[8] = ["September", 30];
        monthName[9] = ["October", 31];
        monthName[10] = ["November", 30];
        monthName[11] = ["December", 31];
        date_today.setDate(date_today.getDate() + 1 - date_today.getDate())
        date_backup.setDate(date_backup.getDate() + 1 - date_backup.getDate())
        $('.cld_left_arrow').attr('month_diff', 0)
        $('.cld_right_arrow').attr('month_diff', 0)
        var first_day_of_first_month = date_today.getDay()
        var first_month = date_today.getMonth()
        var first_month_year = date_today.getFullYear()
        $('.panel1-badge').text(monthName[first_month][0] + ' ' + date_today.getFullYear())
        $('#current_month_text').text(monthName[first_month][0])
        date_today.setMonth(date_today.getMonth() + 1)
        var first_day_of_second_month = date_today.getDay()
        var second_month = date_today.getMonth()
        var second_month_year = date_today.getFullYear()

        $('first_panel').empty()

        var first_panel_trs = ''
        var count = 0
        var date_date = 1
        var month_month = date_backup.getMonth()

        for (let i = 0; i < 6; i++) {
            first_panel_trs = first_panel_trs + '<tr>'
            for (let j = 0; j < 7; j++) {
                if (month_month == date_backup.getMonth()) {
                    if (count >= first_day_of_first_month) {
                        let dd = new Date()

                        let date_today = dd.getFullYear() + '-' + (dd.getMonth() < 9 ? '0' + (dd.getMonth() + 1) : (dd.getMonth() + 1)) + '-' + (dd.getDate() < 10 ? ('0' + dd.getDate()) : dd.getDate())
                        let current_date = date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0' + (date_backup.getMonth() + 1) : (date_backup.getMonth() + 1)) + '-' + (date_backup.getDate() < 10 ? ('0' + date_backup.getDate()) : date_backup.getDate())

                        if (current_date < date_today) {
                            first_panel_trs = first_panel_trs + `<td id="dateid-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}" class="muted custom_calendar_td date-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}" aria-label="${date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + (date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate())}"><span aria-label="${date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + (date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate())}" class="muted custom_calendar date-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}">${date_date}</span></td>`
                        } else {
                            if (current_date == date_today) {
                                first_panel_trs = first_panel_trs + `<td onclick="updateStartDate('${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}')" id="dateid-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}" class="custom_calendar_td btn-success date-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}" aria-label="${date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + (date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate())}"><strong aria-label="${date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + (date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate())}" class="hvr_effect btn-success custom_calendar date-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}">${date_date}</strong></td>`

                            } else {
                                first_panel_trs = first_panel_trs + `<td onclick="updateStartDate('${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}')" id="dateid-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}" class="custom_calendar_td date-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}" aria-label="${date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + (date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate())}"><span aria-label="${date_backup.getFullYear() + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + (date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate())}" class="hvr_effect custom_calendar date-${(date_backup.getDate()<10 ? ('0'+date_backup.getDate()):date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0'+(date_backup.getMonth()+1) : (date_backup.getMonth()+1)) + '-' + date_backup.getFullYear()}">${date_date}</span></td>`

                            }
                        }
                        date_date = date_date + 1
                        date_backup.setDate(date_backup.getDate() + 1)
                        count = count + 1
                    } else {
                        first_panel_trs = first_panel_trs + '<td class="muted custom_calendar_td"></td>'
                        count = count + 1
                    }
                }
            }
            first_panel_trs = first_panel_trs + '</tr>'
        }
        $('.first_panel').html(first_panel_trs)

        let ddd = new Date()
        $('.date' + (date_backup.getDate() < 10 ? ('0' + date_backup.getDate()) : date_backup.getDate()) + '-' + (date_backup.getMonth() < 9 ? '0' + (date_backup.getMonth() + 1) : (date_backup.getMonth() + 1)) + '-' + date_backup.getFullYear()).removeClass('muted')
    })
    $(document).ready(function() {
        <?php
        if (filled($user_work_hours)) :
            foreach ($user_work_hours as $user_work_hour) :
                $work_hour = $user_work_hour->time != '00:00' ? $user_work_hour->time . ' hours' : '00:00';
                $background_color = optional($user_work_hour->daily_performance)->background_color ?? '';
                $font_color = optional($user_work_hour->daily_performance)->font_color ?? '';
                $title = optional($user_work_hour->daily_performance)->title ?? '';
        ?>
                $('#dateid-{{ Carbon\Carbon::parse($user_work_hour->date)->format("d-m-Y") }}').append("<br><div data-toggle='tooltip' title='{{ $title }}' class='badge_red' style='background-color:{{ $background_color }};color:{{ $font_color }};'>{{ $work_hour }}</div>");
        <?php
            endforeach;
        endif;
        ?>
    });

    function getWorkHoursMonthWise(month, year) {
        var user_id = $('#user_data').attr('data-user_id');
        $.ajax({
            type: 'GET',
            url: base_url + '/user-work-hour',
            dataType: 'json',
            data: {
                month: month,
                year: year,
                user_id: user_id
            },
            success: function(result) {
                if (result.status == true) {
                    $('#work_hour_text').text('Total work hours: ' + result.data.total_work_hours);
                    result.data.user_work_hours.forEach(element => {
                        var work_hour = (element.time !== '00:00') ? element.time + ' Hours ' : '00:00';
                        var grade_title = ((element.daily_performance !== null) && (element.daily_performance.title)) ? element.daily_performance.title : '';
                        var background_color = ((element.daily_performance !== null) && (element.daily_performance.background_color)) ? element.daily_performance.background_color : '';
                        var font_color = ((element.daily_performance !== null) && (element.daily_performance.font_color)) ? element.daily_performance.font_color : '';
                        $(".custom_calendar.date-" + moment(element.date).format('DD-MM-YYYY')).after("<div data-toggle='tooltip' class='badge_red' title='" + grade_title + "' style='background-color:" + background_color + ";color:" + font_color + ";'>" + work_hour + "</div>");
                    });
                } else {
                    $('#work_hour_text').text('Total work hours: 0');
                }
            }
        })
    }
</script>