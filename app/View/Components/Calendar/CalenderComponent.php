<?php

namespace App\View\Components\Calendar;

use App\Models\ClickUp;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CalenderComponent extends Component
{

    public $total_work_hours, $user_work_hours, $user_id, $not_show_calender_if_data_not_exit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $userId, bool $notShowCalenderIfDataNotExist = false)
    {
        $total_work_hours_in_sec = ClickUp::with('daily_performance')
                ->select(DB::raw('user_id, SUM(TIME_TO_SEC(time)) AS total_work_time'))
                ->where('user_id', $userId)
                ->whereYear('date', Carbon::now()->year)
                ->whereMonth('date', Carbon::now()->month)
                ->groupBy('user_id')
                ->first();

        $total_work_hours = 0;

        if($total_work_hours_in_sec){
            $total_work_hours = ($total_work_hours_in_sec->total_work_time > 0) ? second_to_hours_minutes($total_work_hours_in_sec->total_work_time) : 0;
        }

        $this->total_work_hours = $total_work_hours;

        $this->user_work_hours = ClickUp::with('daily_performance')
        ->where('user_id', $userId)
        ->whereYear('date', Carbon::now()->year)
        ->whereMonth('date', Carbon::now()->month)
        ->orderBy('date')
        ->get();
        
        $this->user_id = $userId;
        $this->not_show_calender_if_data_not_exit = $notShowCalenderIfDataNotExist;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if($this->not_show_calender_if_data_not_exit){
            if($this->total_work_hours > 0){
                return view('components.calendar.calender-component');
            }
            return false;
        }
        return view('components.calendar.calender-component');
    }
}
