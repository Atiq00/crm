<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Models\Campaign;

class ProjectController extends Controller
{
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "Projects"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
        $this->authorize('projects.index');
        $clients  = Client::all();    
        $projects = Project::with('client.campaign')->withTrashed()->get();    
        $campaigns = Campaign::get(); 

        return view('admin.project.index', compact('clients','projects','campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $clients = \DB::table('clients')->get();
        $project = \DB::table('projects')->latest()->first();
        $code =  str_replace("PRO",'',$project->project_code);
        $code = "PRO".$code+1;
        return view('admin.project.partials.add_new_form', compact('clients','code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $project = \DB::table('projects')->latest()->first();
        $code =  str_replace("PRO",'',$project->project_code);
        $code = "PRO".$code+1;
        $request->merge([
            'project_code' => $code,
        ]);
        $projects = $request->all();
        $projects = Project::create( $projects );
        return redirect()->route('projects.index')->with('success', "Project Create Successfuly");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with('client')->where('id',$id)->withTrashed()->first();
        $clients = \DB::table('clients')->get();
        return view('admin.project.edit', compact('project','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        \DB::table('projects')->where("id",$id)->update([
            'name'=>$request->name, 
            'client_id'=>$request->client_id, 
        ]); 
        return redirect()->route('projects.index')->with('success',"Project update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
