<?php

namespace App\View\Components\Notices;

use App\Models\NoticeManagement;
use Illuminate\View\Component;

class UserNotice extends Component
{
    public $notice;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->notice = NoticeManagement::where('user_id', $userId)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notices.user-notice');
    }
}
