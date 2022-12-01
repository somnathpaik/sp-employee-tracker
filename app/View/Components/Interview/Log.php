<?php

namespace App\View\Components\Interview;

use App\Models\InterviewLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\Component;

class Log extends Component
{
    public $interview_logs;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->interview_logs = InterviewLog::whereHas('interview', function(Builder $builder) use ($userId){
            return $builder->where('employee_user_id', $userId);
        })
        ->latest()
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.interview.log');
    }
}
