<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\User;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "Designation"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('designations.index');
        $designations  =   Designation::all();
        $users = User::get();
        return view('admin.designation.index', compact('designations','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('designations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->authorize('designations.create');

        $designation = $request->all();
        $designation = Designation::create( $designation );
        return redirect()->route('designations.index')->with('success', "Designation Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        $this->authorize('designations.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        $this->authorize('designations.edit'); 
        return view('admin.designation.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
        $this->authorize('designations.update');        
        $designation->update($request->all());
        return redirect()->route('designations.index')->with('success',"Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        //
    }
}
