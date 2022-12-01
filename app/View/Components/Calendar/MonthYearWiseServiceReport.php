<?php

namespace App\View\Components\Calendar;

use App\Models\ClientResource;
use App\Models\DailyPerformance;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class MonthYearWiseServiceReport extends Component
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

        $years = ClientResource::where('working_user_id', $userId)
        ->select(DB::raw('DISTINCT(year) AS year_value'))
        ->orderBy('year_value', 'desc')
        ->get();

        if($years->count() > 0){
            foreach($years as $year){
                for ($month = 1; $month <= 12; $month++) {
                    $month_name = date("F", mktime(0, 0, 0, $month, 10));

                    $work_hours = ClientResource::query()->where([
                        ['working_user_id', '=', $userId],
                        ['month', '=', $month_name],
                        ['year', '=', $year->year_value],
                        ])->sum('hours');

                    $report[$year->year_value][$month_name]['work_hour'] = $work_hours ?? 0;
                    $report[$year->year_value][$month_name]['back_ground_color'] = getColorBasedOnMonthYearWiseWorkHour($work_hours)['back_ground_color'];
                    $report[$year->year_value][$month_name]['front_color'] = getColorBasedOnMonthYearWiseWorkHour($work_hours)['front_color'];
                    $report[$year->year_value][$month_name]['title'] = getColorBasedOnMonthYearWiseWorkHour($work_hours)['title'];
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
        return view('components.calendar.month-year-wise-service-report');
    }
}
