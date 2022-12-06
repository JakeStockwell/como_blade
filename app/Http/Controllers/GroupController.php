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
        $groups_i_made = User::find($c_user->id)->groups;

        // $group_members = DB::table('members')
        //             ->leftJoin('groups', 'members.group_id', '=', 'groups.id')
        //             ->leftJoin('users', 'members.user_id', '=', 'users.id')
        //             ->select('groups.group_name', 'users.name', 'users.email')
        //             ->where('users.id', $c_user->id)
        //             ->get();

        $group_members = User::find($c_user->id)->members;
 
        foreach($group_members as $group){
            $my_groups = Group::find($group->group_id);
            $group->group_name = $my_groups->group_name;
            //$group->put('group_name', $my_groups->group_name);
        }
        
        //dd($group_members);
        //dd($my_groups);
        return view('groups.index', [
            'groups' => $groups_i_made,
            'c_user' => $c_user,
            'group_members' => $group_members,
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
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        $c_user = $request->user();
        $my_groups = User::find($c_user->id)->groups;
        $group_members = Group::find($group->id)->members;
//dd($my_groups);
        return view('groups.view', [
            'group' => $group,
            'my_groups' => $my_groups,
            'c_user' => $c_user,
            //'members' => Member::with('group')->latest()->get(),
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
