<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use App\Http\Requests\PriorityRequest;

class PriorityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>   __('labels.priority')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('priority.index');
        
        $priorities  =   Priority::all();
        return view('admin.priority.index', compact('priorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('priority.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriorityRequest $request)
    {
        $this->authorize('priority.create');

        $priority = Priority::create( $request->all() );
        return redirect()->route('priorities.index')->with('success', __('messages.priority_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function show(Priority $priority)
    {
        $this->authorize('priority.index');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function edit(Priority $priority)
    {
        $this->authorize('priority.edit');
        return view('admin.priority.edit', compact('priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function update(PriorityRequest $request, Priority $priority)
    {
        $this->authorize('priority.edit');
        
        $priority->update($request->all());

        return redirect()->route('priorities.index')->with('success',__('messages.priority_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function destroy(Priority $priority)
    {
        $this->authorize('priority.delete');
        $priority->delete();
        return redirect()->route('priorities.index')->with('success', __('messages.priority_deleted'));
    }
}
