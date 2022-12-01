<script>
    $('.cld_left_arrow').on('click', function() {

        let date_today = new Date();
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
        var monthdiffleft = parseInt($('.cld_left_arrow').attr('month_diff'))
        var monthdiffright = parseInt($('.cld_right_arrow').attr('month_diff'))
        if (monthdiffright == 0) {
            monthdiff = monthdiffleft
            date_today.setMonth(date_today.getMonth() - monthdiff - 1)
            $('.cld_left_arrow').attr('month_diff', monthdiff + 1)
        } else {
            monthdiff = monthdiffright
            date_today.setMonth(date_today.getMonth() + monthdiff - 1)
            $('.cld_right_arrow').attr('month_diff', monthdiff - 1)
        }

        var first_day_of_first_month = date_today.getDay()
        var first_month = date_today.getMonth();
        var first_month_year = date_today.getFullYear()
        $('#second_panel_month').text($('#first_panel_month').text())
        $('#first_panel_month').text(monthName[first_month][0] + ' ' + first_month_year)
        $('#current_month_text').text(monthName[first_month][0])
        var first_panel_trs = ''
        var count = 0
        var date_date = 1
        $('.second_panel').html($('.first_panel').html())
        var month_month = date_today.getMonth()
        for (let i = 0; i < 6; i++) {
            first_panel_trs = first_panel_trs + '<tr>'
            for (let j = 0; j < 7; j++) {
                if (month_month == date_today.getMonth()) {
                    if (count >= first_day_of_first_month) {
                        let dd = new Date()
                        let date_today1 = dd.getFullYear() + '-' + (dd.getMonth() < 9 ? '0' + (dd.getMonth() + 1) : (dd.getMonth() + 1)) + '-' + (dd.getDate() < 10 ? ('0' + dd.getDate()) : dd.getDate())
                        let current_date1 = date_today.getFullYear() + '-' + (date_today.getMonth() < 9 ? '0' + (date_today.getMonth() + 1) : (date_today.getMonth() + 1)) + '-' + (date_today.getDate() < 10 ? ('0' + date_today.getDate()) : date_today.getDate())

                        if (current_date1 < date_today1) {
                            first_panel_trs = first_panel_trs + `<td class="muted custom_calendar_td date-${(date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate()) + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + date_today.getFullYear()}" aria-labe="${date_today.getFullYear() + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + (date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate())}"><span aria-label="${date_today.getFullYear() + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + (date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate())}" class="muted custom_calendar date-${(date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate()) + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + date_today.getFullYear()}">${date_date}</span></td>`
                        } else {
                            first_panel_trs = first_panel_trs + `<td class="custom_calendar_td date-${(date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate()) + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + date_today.getFullYear()}" aria-labe="${date_today.getFullYear() + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + (date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate())}"><span aria-label="${date_today.getFullYear() + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + (date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate())}" class="hvr_effect custom_calendar date-${(date_today.getDate()<10 ? ('0'+date_today.getDate()):date_today.getDate()) + '-' + (date_today.getMonth() < 9 ? '0'+(date_today.getMonth()+1) : (date_today.getMonth()+1)) + '-' + date_today.getFullYear()}">${date_date}</span></td>`

                        }
                        date_date = date_date + 1
                        date_today.setDate(date_today.getDate() + 1)
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

        var startRange = $('.startRange').attr('aria-label')
        var endRange = $('.endRange').attr('aria-label')
        var inRange = $('.inRange')
        var d = new Date(startRange)
        let id = '.date-' + (d.getDate() < 10 ? ('0' + d.getDate()) : d.getDate()) + '-' + (d.getMonth() < 9 ? ('0' + (d.getMonth() + 1)) : (d.getMonth() + 1)) + '-' + d.getFullYear()

        $('.date-' + (d.getDate() < 10 ? ('0' + d.getDate()) : d.getDate()) + '-' + (d.getMonth() < 9 ? ('0' + (d.getMonth() + 1)) : (d.getMonth() + 1)) + '-' + d.getFullYear()).addClass('btn-highlighted')
        $('.custom_calendar_td').removeClass('btn-highlighted')

        var t = new Date(endRange)
        let id2 = '.date-' + (t.getDate() < 10 ? ('0' + t.getDate()) : t.getDate()) + '-' + (t.getMonth() < 9 ? ('0' + (t.getMonth() + 1)) : (t.getMonth() + 1)) + '-' + t.getFullYear()
        $('.date-' + (t.getDate() < 10 ? ('0' + t.getDate()) : t.getDate()) + '-' + (t.getMonth() < 9 ? ('0' + (t.getMonth() + 1)) : (t.getMonth() + 1)) + '-' + t.getFullYear()).addClass('btn-highlighted')
        $('.custom_calendar_td').removeClass('btn-highlighted')
        var s = ''
        if (startRange != undefined && endRange != undefined && startRange != endRange) {
            $('.date-' + (d.getDate() < 10 ? ('0' + d.getDate()) : d.getDate()) + '-' + (d.getMonth() < 9 ? ('0' + (d.getMonth() + 1)) : (d.getMonth() + 1)) + '-' + d.getFullYear()).addClass('bg_td_style')
            $('.date-' + (d.getDate() < 10 ? ('0' + d.getDate()) : d.getDate()) + '-' + (d.getMonth() < 9 ? ('0' + (d.getMonth() + 1)) : (d.getMonth() + 1)) + '-' + d.getFullYear()).addClass('bg_td')
            $('.date-' + (d.getDate() < 10 ? ('0' + d.getDate()) : d.getDate()) + '-' + (d.getMonth() < 9 ? ('0' + (d.getMonth() + 1)) : (d.getMonth() + 1)) + '-' + d.getFullYear()).addClass('check_in_date')
            $('.date-' + (t.getDate() < 10 ? ('0' + t.getDate()) : t.getDate()) + '-' + (t.getMonth() < 9 ? ('0' + (t.getMonth() + 1)) : (t.getMonth() + 1)) + '-' + t.getFullYear()).addClass('bg_td_style1')
            $('.date-' + (t.getDate() < 10 ? ('0' + t.getDate()) : t.getDate()) + '-' + (t.getMonth() < 9 ? ('0' + (t.getMonth() + 1)) : (t.getMonth() + 1)) + '-' + t.getFullYear()).addClass('bg_td')
            $('.date-' + (t.getDate() < 10 ? ('0' + t.getDate()) : t.getDate()) + '-' + (t.getMonth() < 9 ? ('0' + (t.getMonth() + 1)) : (t.getMonth() + 1)) + '-' + t.getFullYear()).addClass('check_out_date')
            $('.custom_calendar').removeClass('bg_td_style1')
            $('.custom_calendar').removeClass('bg_td_style')
            $('.custom_calendar').removeClass('bg_td')
            $('.custom_calendar_td').removeClass('check_out_date')
            $('.custom_calendar_td').removeClass('check_in_date')
            inRange.each(function() {
                var thisrange = $(this).attr('aria-label')
                s = new Date(thisrange)
                let id3 = '.date-' + (s.getDate() < 10 ? ('0' + s.getDate()) : s.getDate()) + '-' + (s.getMonth() < 9 ? ('0' + (s.getMonth() + 1)) : (s.getMonth() + 1)) + '-' + s.getFullYear()
                $(id3).addClass('bg_td')
                $('.custom_calendar').removeClass('bg_td')
            });
        }
        
        getWorkHoursMonthWise(date_today.getMonth(), date_today.getFullYear());
    })
</script>