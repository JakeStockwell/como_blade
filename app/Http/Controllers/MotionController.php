<?php

namespace App\Http\Controllers;

use App\Models\Motion;
use Illuminate\Http\Request;

class MotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('motions.index', [

            'motions' => Motion::with('user')->latest()->get(),
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
        $validated = $request->validate([
            'motion' => 'required|string|max:255',
        ]);

        $request->user()->motions()->create($validated);

        return redirect(route('motions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function show(Motion $motion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function edit(Motion $motion)
    {
        $this->authorize('update', $motion);
 
        return view('motions.edit', [
            'motion' => $motion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motion $motion)
    {
        $this->authorize('update', $motion);
 
        $validated = $request->validate([
            'motion' => 'required|string|max:255',
        ]);
 
        $motion->update($validated);
 
        return redirect(route('motions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motion  $motion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motion $motion)
    {
        $this->authorize('delete', $motion);
 
        $motion->delete();
 
        return redirect(route('motions.index'));
    }
}
