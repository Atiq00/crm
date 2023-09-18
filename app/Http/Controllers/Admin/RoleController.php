<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.roles')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('role.index');
        $roles  =   Role::all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('role.create');
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('role.create');
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        $data   =   $request->only(['name']);
        $data['guard_name'] =   'web';
        $role = Role::create($data);

        foreach($request->get('permissions') as $prm){
            $role->givePermissionTo($prm);
        }
     
        return redirect()->route('roles.index')->with('success', __('messages.role_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('role.index');
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
        $this->authorize('role.edit');
        $role = Role::findOrFail($id);
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('admin.role.edit', compact('role', 'permissions'));
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
        $this->authorize('role.edit');
        $request->validate([
            "name" => "required|unique:roles,id,$id|max:255",
        ]);

        $role = Role::find($id);

        $role->update($request->only(['name']));

        foreach ($request->get('permissions') as $value) {
            $permissions[] = $value;
        }
        // dd($permissions->get('permissions'));

        $role->syncPermissions($request->get('permissions'));
     
        return redirect()->route('roles.index')->with('success', __('messages.role_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('role.delete');

        if(in_array($id, [1,2]))
            return redirect()->route('roles.index')->with('error', __('You are not allowed to delete these roles ! System roles cannot be deleted'));

        // dd($id);

        $role = Role::findOrFail($id);
        
        foreach($role->users as $user){
            User::find($user->id)->delete();
        }

        $role->syncPermissions([]);
        // dd($role);
        $role->delete();
     
        return redirect()->route('roles.index')->with('success', __('messages.role_deleted'));
    }
}
