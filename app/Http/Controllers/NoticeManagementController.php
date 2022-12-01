<?php

namespace App\Http\Controllers;

use App\Models\NoticeManagement;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\NoticeManagement\CreateRequest;
use App\Http\Requests\NoticeManagement\UpdateRequest;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class NoticeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_notice_type = $request->get('search_notice_type');
        $search_notice_level = $request->get('search_notice_level');
        $search_notice_user = $request->get('search_notice_user');

        $notices = NoticeManagement::when($search_notice_type, function (Builder $builder, $value) {
            return $builder->where('notice_type', $value);
        })->when($search_notice_level, function (Builder $builder, $value) {
            return $builder->where('notice_level', $value);
        })->when($search_notice_user, function (Builder $builder, $value) {
            return $builder->whereHas('user', function (Builder $builder) use ($value) {
                return $builder->whereRaw("concat(name, ' ', last_name) like '%" . $value . "%' ");
            });
        })
            ->with('user')
            ->whereHas('user')
            ->latest()
            ->paginate(config('setting.pagination_no'));

        return view('notice_management.index', [
            'notices' => $notices
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
            ->doesntHave('noticeManagement')
            ->orderByRaw('CONCAT(name, " ", last_name) asc')
            ->get();

        return view('notice_management.create', [
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

            NoticeManagement::create($data);

            return Redirect::route('notice-management.index')->with([
                'success' => 'Data save successful.'
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }
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
        $notice = NoticeManagement::with('user')
            ->whereHas('user')
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('notice_management.edit', [
            'notice' => $notice,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, string $uuid)
    {
        $data = $request->validated();

        $notice = NoticeManagement::where('uuid', $uuid)->firstOrFail();

        try {

            $notice->update($data);

            return Redirect::route('notice-management.index')->with([
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
        $notice = NoticeManagement::where('uuid', $uuid)->firstOrFail();

        try {
            $notice->delete();

            return Redirect::route('notice-management.index')->with([
                'success' => 'Data deleted successful.'
            ]);
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }
    }
}
