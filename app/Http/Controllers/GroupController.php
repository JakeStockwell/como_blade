<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('como_slug')->only('store');
        //$this->middleware('log')->only('index');
        //$this->middleware('subscribed')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $c_user = $request->user();

        /** Get the Group names that this user belongs to : Query Builder*/
        // $group_members = DB::table('members')
        //             ->leftJoin('groups', 'members.group_id', '=', 'groups.id')
        //             ->leftJoin('users', 'members.user_id', '=', 'users.id')
        //             ->select('groups.group_name', 'users.name', 'users.email')
        //             ->where('users.id', $c_user->id)
        //             ->get();

        /** Get the Groups that this user belongs to : Eloquent */
        $my_groups = Member::with(['user', 'group'])->whereUserId($c_user->id)->get();

        /** Get the Groups that this user created : Eloquent */
        $groups_i_made = User::find($c_user->id)->groups;

        /** Get the Groups that this user doesn't belong to : Eloquent */
        $not_my_groups = Group::whereDoesntHave('members', function($query) {$query->whereIn('user_id', ['6']);})->get();

        return view('groups.index', [
            'groups' => $my_groups,
            'groups_i_made' => $groups_i_made,
            'not_my_groups' => $not_my_groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:255',
            'slug' => 'required|unique:groups|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('groups.index'))
                        ->withErrors('You\'ve already used that Group name. Please choose another!')
                        ->withInput();
        }

        $validated = $validator->validated();

        $request->user()->groups()->create($validated);

        return redirect(route('groups.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @param  \App\Models\Group  $not_my_groups
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        $c_user = $request->user();
        $groups_i_made = User::find($c_user->id)->groups;
        $my_groups = Member::with(['user', 'group'])->whereUserId($c_user->id)->get();
        $group_members = Member::with(['group', 'user'])->whereGroupId($group->id)->get();

        /** Check if the current user is a member of the current group */
        $member = Member::where('group_id', '=', $group->id, 'and')->where('user_id', '=', $c_user->id)->first();

        /** Get the Groups that this user doesn't belong to : Eloquent */
        $not_my_groups = Group::whereDoesntHave('members', function($query) {$query->whereIn('user_id', ['6']);})->get();
//dd($my_groups);
        return view('groups.view', [
            'group' => $group,
            'groups_i_made' => $groups_i_made,
            'my_groups' => $my_groups,
            'not_my_groups' => $not_my_groups,
            'c_user' => $c_user,
            'member' => $member,
            'members' => $group_members,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $this->authorize('update', $group);
 
        return view('groups.edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);
 
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
        ]);
 
        $group->update($validated);
 
        return redirect(route('groups.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);

        $group->delete();

        return redirect(route('groups.index'));
    }
}
