<?php

namespace App\View\Components\Calendar;

use App\Models\ClickUp;
use App\Models\DailyPerformance;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class YearCalendar extends Component
{
    public $work_report;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct(int $userId)
    {
        $report = [];

        $years = ClickUp::query()->where('user_id', $userId)
            ->select(DB::raw('DISTINCT(YEAR(date)) AS year_value'))
            ->orderBy('year_value', 'desc')
            ->get();

        if ($years->count() > 0) {
            foreach ($years as $year) {
                for ($month = 1; $month <= 12; $month++) {

                    $total_work_hours_in_sec = ClickUp::select(DB::raw('user_id, SUM(TIME_TO_SEC(time)) AS total_work_time'))
                        ->where('user_id', $userId)
                        ->whereYear('date', $year->year_value)
                        ->WhereMonth('date', $month)
                        ->groupBy('user_id')->first();

                    $work_hours = 0;
                    $color_work_hours = 0;
                    if ($total_work_hours_in_sec) {
                        $work_hours = ($total_work_hours_in_sec->total_work_time > 0) ? second_to_hours_minutes($total_work_hours_in_sec->total_work_time) : 0;
                        $color_work_hours = ($total_work_hours_in_sec->total_work_time > 0) ? second_to_hours($total_work_hours_in_sec->total_work_time) : 0;
                    }

                    $month_name = date("F", mktime(0, 0, 0, $month, 10));
                    $report[$year->year_value][$month_name]['work_hour'] = $work_hours ?? 0;
                    $report[$year->year_value][$month_name]['back_ground_color'] = getColorBasedOnMonthYearWiseWorkHour($color_work_hours)['back_ground_color'];
                    $report[$year->year_value][$month_name]['front_color'] = getColorBasedOnMonthYearWiseWorkHour($color_work_hours)['front_color'];
                    $report[$year->year_value][$month_name]['title'] = getColorBasedOnMonthYearWiseWorkHour($color_work_hours)['title'];
                }
            }
        }
        $this->work_report = $report;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.calendar.year-calendar');
    }
}
