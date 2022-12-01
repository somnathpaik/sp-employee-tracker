<?php

use App\Models\DailyPerformance;
use App\Models\Teams;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\NoticeManagement;
use Illuminate\Support\Carbon;

if (!function_exists('getColorBasedOnMonthYearWiseWorkHour')) {

    function getColorBasedOnMonthYearWiseWorkHour($work_hour = 0): array
    {

        $day_work_hours = ($work_hour / 22);
        //dump($day_work_hours);
        $color = DailyPerformance::query()
            ->where('min', '<=', intval($day_work_hours))
            ->where('max', '>', intval($day_work_hours))
            ->first();

        if ($color instanceof DailyPerformance) {
            return [
                'back_ground_color' => $color->background_color,
                'front_color' => $color->font_color,
                'title' => $color->title
            ];
        } else {
            return [
                'back_ground_color' => '#002589',
                'front_color' => '#f5f5f5',
                'title' => 'Wrong Entry'
            ];
        }
    }
}

if (!function_exists('get_team_id')) {
    function get_team_id()
    {
        $team = Teams::first();
        $id = '';
        if ($team instanceof Teams) {
            $id = $team->id;
        }
        return $id;
    }
}

if (!function_exists('activeSegment')) {
    function activeSegment($name, $segment = 1, $class = 'active')
    {
        return request()->segment($segment) == $name ? $class : '';
    }
}

if (!function_exists('paginate_iteration')) {
    function paginate_iteration($iteration, LengthAwarePaginator $pagination): int
    {
        $per_page = $pagination->perPage();
        $current_page = $pagination->currentPage();
        if ($current_page > 1) {
            return (int) ($iteration + (($current_page - 1) * $per_page));
        }
        return (int) $iteration;
    }
}

if (!function_exists('second_to_hours_minutes')) {
    function second_to_hours_minutes($seconds = 0)
    {
        if ($seconds <= 0) {
            return 0;
        }
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);

        return "$hours:$minutes";
    }
}

if (!function_exists('second_to_hours')) {
    function second_to_hours($seconds = 0)
    {
        if ($seconds <= 0) {
            return 0;
        }
        $hours = floor($seconds / 3600);
        return "$hours";
    }
}

if (!function_exists('carbon_date_time')) {
    function carbon_date_time($date_time = 0)
    {
        if ($date_time <= 0) {
            return '';
        }
        return new Carbon($date_time);
    }
}