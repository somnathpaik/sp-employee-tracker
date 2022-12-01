<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests\Interview\CreateRequest;
use App\Http\Requests\Interview\UpdateRequest;
use App\Models\InterviewLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interviews  = Interview::with('user')
        ->whereHas('user')
        ->latest()
        ->paginate(config('setting.pagination_no'));

        return view('interviews.index',[
            'interviews' => $interviews
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::withTrashed()
            ->whereNotIn('email', User::ADMIN_EMAILS)
            ->doesntHave('interview')
            ->orderByRaw('CONCAT(name, " ", last_name) asc')
            ->get();

        return view('interviews.create', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->validated();

        try {

            $data['uuid'] = Str::uuid();

            DB::transaction(function () use($data) {
                $interview = Interview::create($data);                
                $interview->interviewLog()->create([
                    'admin_user_id' => auth()->id(),
                    'employee_user_id' => $data['user_id'],
                    'date_time' => $data['date_time'],
                    'status' => $data['status'],
                ]);    
            });
            
            return Redirect::route('interview.index')->with([
                'success' => 'Data save successful.'
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(string $uuid)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(string $uuid)
    {
        $users = User::withTrashed()        
        ->whereNotIn('email', User::ADMIN_EMAILS)
        ->orderByRaw('CONCAT(name, " ", last_name) asc')
        ->get();

        $interview = Interview::with(['user', 'interviewLog'])
        ->whereHas('user')
        ->where('uuid', $uuid)
        ->firstOrFail();

        $interview_logs = InterviewLog::where('interview_id', $interview->id)
        ->with(['employeeUser'])
        ->latest()
        ->paginate(config('setting.pagination_no'));

        return view('interviews.edit', [
            'interview' => $interview,
            'users' => $users,
            'interview_logs' => $interview_logs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, string $uuid)
    {
        $data = $request->validated();

        $interview = Interview::where('uuid', $uuid)->firstOrFail();

        try {            

            DB::transaction(function () use($interview, $data) {
                $interview->update($data);                
                $interview->interviewLog()->create([
                    'admin_user_id' => auth()->id(),
                    'employee_user_id' => $data['user_id'],
                    'date_time' => $data['date_time'],
                    'status' => $data['status'],
                ]);    
            });

            return Redirect::route('interview.index')->with([
                'success' => 'Data update successful.'
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $uuid)
    {
        $interview = Interview::where('uuid', $uuid)->firstOrFail();

        try {
            $interview->delete();

            return Redirect::route('interview.index')->with([
                'success' => 'Data deleted successful.'
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function log(string $uuid){

        $interview_logs = InterviewLog::whereHas('interview', function(Builder $builder) use ($uuid){
            return $builder->where('uuid', $uuid);
        })
        ->with(['employeeUser'])
        ->latest()
        ->paginate(config('setting.pagination_no'));

        return view('interviews.log', [
            'interview_logs' => $interview_logs,
        ]);
    }
}
