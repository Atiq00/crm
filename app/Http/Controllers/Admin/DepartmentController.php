<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;

use App\User;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.departments')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $this->authorize('department.index');
        $departments  =   Department::all();
        $users = User::get();
        return view('admin.department.index', compact('departments', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $this->authorize('department.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {        
        $this->authorize('department.create');

        $department = $request->all();
        
        $department['assigned_user_id'] =  $department['assigned_user_id'] > 0 ? $department['assigned_user_id'] : null ;

        $department = Department::create( $department );
        return redirect()->route('departments.index')->with('success', __('messages.department_created'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {        
        $this->authorize('department.index');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {        
        $this->authorize('department.edit');
        $users = User::get();
        return view('admin.department.edit', compact('department', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {        
        $this->authorize('department.update');
        
        $department->update($request->all());

        return redirect()->route('departments.index')->with('success',__('messages.department_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {        
        $this->authorize('department.delete');
        $department->delete();
        return redirect()->route('departments.index')->with('success', __('messages.department_deleted'));
    }
}
