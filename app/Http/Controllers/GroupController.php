<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return view('groups.index', [
            'groups' => Group::with('user')->latest()->get(),
            'c_user' => $request->user(),
            'exists' => $request->found,
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
        // $validated = $request->validate([
        //     //'group_name' => 'required|string|unique:groups|max:255',
        //     'slug' => 'required|string|unique:groups|max:255',
        // ]);

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
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('groups.view', [
            'groups' => Group::with('user')->latest()->get(),
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
