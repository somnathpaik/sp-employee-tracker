<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\SkillsEducation;
use App\Models\Clients;
use App\Models\ClientStatus;
use Auth;
use App\Models\ClientResource;
use App\Models\ClickUp;
use App\Models\WorkingHour;

use App\Models\WorkType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data['clinents'] = Clients::withCount(['clientResourceAll as client_resource_all_count' => function(Builder $builder){
            return $builder->select(DB::raw('COUNT(DISTINCT(service_id))'))->where([
                ['year', Carbon::now()->year],
                ['month', Carbon::now()->format('F')],
            ]);
        }])->whereHas('client_resource')
        ->orderBy('client_resource_all_count', 'desc')
        ->get();
        $data['work_type_count'] = WorkType::with('work_type_user_count')->get();
        
        $data['current_month'] = User::whereNotIn('email', User::ADMIN_EMAILS)->whereMonth(
            'created_at',
            '=',
            Carbon::now()->month
        )->count();
        $data['total_client'] = Clients::distinct('client_email')->count();

        $data['total_services'] = ClientResource::where('month', Carbon::now()->format('F'))
        ->where('year', Carbon::now()->year)
        ->distinct('service_id')
        ->count('service_id');
        
        //$data['total_users'] = User::where('id', '!=', 1)->count();
        $data['total_users'] = User::whereNotIn('email', User::ADMIN_EMAILS)->count();
        $data['active_client'] = Clients::whereHas('client_type', function ($q) {
            $q->where('title', '=', 'active');
        })->count();

        $data['zeo_three'] = User::where('experience', '>=', 1)->where('experience', '<', 3)->count();

        $data['three_five'] = User::where('experience', '>=', 3)->where('experience', '<', 5)->count();
        $data['five_ten'] = User::where('experience', '>=', 5)->where('experience', '<', 10)->count();
        $data['ten_fifty'] = User::where('experience', '>=', 10)->where('experience', '<', 30)->count();
        $data['technology'] = SkillsEducation::withCount(['active_skills', 'primary_skills_user', 'secondary_skills_user', 'learning_skills_user'])
            ->where(['category' => 'skill'])->where('show_on_front', '=', '1')->orderBy('active_skills_count', 'DESC')->get();
        // dd( $data['technology']->toArray());

        $data['client_status'] =  ClientStatus::withCount('client_status_count')->orderBy('order_by', 'asc')->get();


        // $currentmonthhours =    ClickUp::whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->get();

        // $currentmonthResourcesCount =    ClickUp::whereMonth('created_at', date('m'))
        //     ->whereYear('created_at', date('Y'))
        //     ->get()->groupBy('user_id')->count();
        //$currentmonthResourcesCount =    User::count();
        $currentmonthResourcesCount =    User::whereNotIn('email', User::ADMIN_EMAILS)->count();

        // if (count($currentmonthhours) > 0) {
        //     foreach ($currentmonthhours as $time) {
        //         list($hour, $minute) = explode(':', $time->time);
        //         $minutes += $hour * 60;
        //         $minutes += $minute;
        //     }

        //     $hours = floor($minutes / 60);
        //     $minutes -= $hours * 60;

        //     $current_mont_spend_hours =    $hours;
        //     $currentmonthResourcesTotal = $currentmonthResourcesCount * 176;
        //     $data['banch_percent'] = ($currentmonthResourcesTotal - $current_mont_spend_hours) / 100;
        // } else {
        //     $data['banch_percent'] = 0;
        // }
        $month = date('F');
        $year = date('Y');
        $currentmonthhours =    ClientResource::where('month',  $month)
            ->where('year', $year)
            ->get()->sum('hours');
        $totalHours = WorkingHour::select('hours')->where('month',  $month)
            ->where('year', $year)->first();

        $totalHours = (!empty($totalHours->hours)) ? $totalHours->hours : 176;


        // echo $totalHours . "<br/>";
        // dd($currentmonthResourcesCount);
        $resource = ($currentmonthResourcesCount) * $totalHours;
        $bench =  ((($resource - $currentmonthhours) / $resource) * 100);
        $data['banch_percent'] =   number_format($bench, 2);
        //new formula for banch 
        // $currentmonthResourcesCount 
        $work_type_count = $data['work_type_count'];
        // dd(     $work_type_count->toArray());
        foreach ($work_type_count as $key => $users) {
            $temp[$users->title] = count($users->work_type_user_count);
            $array = $temp;
        }

        $total_user = $currentmonthResourcesCount;
        
        $full = 0;
        $none = 0;
        $half = 0;
        $hf_adh = 0;
        $adh = 0;
        foreach ($array as $key => $result) {
            if ($key == 'FULL') {
                $full = $result;
            }
            if ($key == 'NONE') {
                $none = $result;
            }
            if ($key == 'HF + ADH') {
                $hf_adh = $result;
            }
            if ($key == 'HALF') {
                $half = $result;
            }
            if ($key == ' ADH') {
                $adh = $result;
            }
        }

        //$benchpercentage = round(((($none*1) + ($half * 0.5) + ($adh * 0.75) + ($hf_adh * 0.25)) / ($total_user-1)) * 100, 2);
        $benchpercentage = round(((($none*1) + ($half * 0.5) + ($adh * 0.75) + ($hf_adh * 0.25)) / ($total_user)) * 100, 2);
        
        $data['banch_percent'] = $benchpercentage;
        //end of new formula for bach
        return view('home', compact('data'));
    }
}
