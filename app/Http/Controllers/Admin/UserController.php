<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Setting;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.users')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('users.index');
        $users  =   User::all();
        $designation  =   User::whereNotNull('designation')->groupBy('designation')->pluck('designation');
        return view('admin.users.index', compact('users','designation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designation  =   User::whereNotNull('designation')->groupBy('designation')->pluck('designation');
        $this->authorize('users.create');
        $roles = Role::where('id',">",1)->get();
        return view('admin.users.create', compact('roles','designation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('users.create');        
        $data   =   $request->except('role','password_confirmation');
        $data['password']   =   Hash::make($request->get('password'));
		$user['image'] = 'default.jpg';
		$user['pseudo_name'] = @$request->pseudo_name; 
		$data['designation'] = @$request->get('designation');
        $designation = \DB::table('designations')->where('name',@$request->get('designation'))->first();	
        if($designation){
            $data['designation_id'] = $designation->id;
        }	 
        if($request->role=="SolarClient" || $request->role=="MortgageClient" || $request->role=="HomeWarrantyClient" ) 
            $user['type'] = 'Client';
        else
            $user['type'] = 'User';
        $user = User::create($data);
        $user->syncRoles([$request->role]);
        $file_name = uniqid().'.jpg';
        if($request->hasFile('image')){
            $request->file('image')->storeAs('user', $file_name, 'uploads');
            $user->image = $file_name;
            $user->update();
        }else{

            //Storage::disk('uploads')->copy('user/default.jpg', 'user/'.$file_name);

            //$user->image = 'default.jpg';
            //$user->update();
        }


        return redirect()->route('users.index')->with('success', __('messages.user_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        $this->authorize('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $designation  =   User::whereNotNull('designation')->groupBy('designation')->pluck('designation');
        $this->authorize('users.edit');

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles','designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        try{
            // return $request;
            $this->authorize('users.edit');
            $data = $request->only(['name', 'email']);
            if(!empty($request->get('password'))){
                $data['password']   =   Hash::make($request->get('password'));
            }
            if(!empty($request->get('reporting_to_id'))){
                $data['reporting_to_id'] = $request->get('reporting_to_id');
            }
            if(!empty($request->get('HRMSID'))){
                $data['HRMSID'] = $request->get('HRMSID');
            }
            if(!empty($request->get('designation'))){
                $data['designation'] = $request->get('designation');
            }

            $designation = \DB::table('designations')->where('name',@$request->get('designation'))->first();	
            if($designation){
                $data['designation_id'] = $designation->id;
            }
            $user['pseudo_name'] = @$request->pseudo_name;
            if($request->hasFile('image')){
                $file_name = uniqid().'.png';            
                if($user->image!='default.png')
                    Storage::disk('uploads')->delete( 'user/'.$user->image );            
                $request->file('image')->storeAs('user', $file_name, 'uploads');
                $data['image'] = $file_name;
            }
            
            $user->update($data);
            $user->removeRole( $user->getRoleNames()[0] );
            $user->assignRole($request->role);


            return redirect()->route('users.index')->with('success', "Update Successfully");
        }catch(\Exception $e){
            return $e->getMessage();
            return redirect()->route('users.index')->with('success',$e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('users.delete');
        $user->delete();
        return redirect()->route('users.index')->with('success', __('messages.user_deleted'));
    }
    public function client_users()
    { 
        $users  =   User::with('projects')->where('type',"Client")->get(); 
        return view('admin.users.client_users', compact('users'));
    }
    public function createclient_user(Request $request)
    { 
         
        if($request->submit == "client_submit"){
            $data   =   $request->except('role','projects','password_confirmation','submit');
            $data['password']   =   Hash::make($request->get('password')); 
            $data['designation'] =  $request->get('designation');               
            $data['type'] = 'Client'; 
            $user = User::create($data);    

            \DB::table("model_has_roles")->insert([
                'model_id' => $user->id,
                'role_id' => $request->role
            ]);     
            $file_name = uniqid().'.jpg';
            if($request->hasFile('image')){    
                $request->file('image')->storeAs('user', $file_name, 'uploads');    
                $user->image = $file_name;
                $user->update();    
            }
            foreach($request->projects as $project){
                \DB::table("client_projects")->insert([
                    'user_id' => $user->id,
                    'project_id' => $project
                ]);
            }

            return redirect()->route('client_users')->with('success', "Client Create Successfully");
                
        }
        $roles = Role::where('id',">",1)->where(function($query){
            $query->where("name","LIKE","%"."client"."%")->orwhere("name","LIKE","%"."client"."%");
        })->get();
        $designation  =   User::whereNotNull('designation')->where('type',"Client")->groupBy('designation')->pluck('designation');
        $users  =   User::with('projects')->where('type',"Client")->get(); 
        $projects  =   Project::  get(); 
        return view('admin.users.create_client', compact('users','roles','designation','projects'));
    }

    public function edit_client_user(Request $request,$id=null){
        if($request->submit == "client_submit"){
            $user   =   User::where('id',$request->user_id)->first();
            if($request->get('password'))
            $user->password   =   Hash::make($request->get('password'));                
            $user->type = 'Client'; 
            $user->name = $request->name; 
            $user->HRMSID=$request->HRMSID; 
            $user->email=$request->email;                  
            $file_name = uniqid().'.jpg';
            if($request->hasFile('image')){    
                $request->file('image')->storeAs('user', $file_name, 'uploads');    
                $user->image = $file_name;    
            } $user->save(); 
            \DB::table('client_projects')->where('user_id',$user->id)->delete();
            if($request->projects){
                foreach($request->projects as $project){
                    \DB::table("client_projects")->insert([
                        'user_id' => $user->id,
                        'project_id' => $project
                    ]);
                }
            }
            
            return redirect()->back()->with('success', "Client update Successfully");                
        }
        $roles = Role::where('id',">",1)->where(function($query){
            $query->where("name","LIKE","%"."client"."%")->orwhere("name","LIKE","%"."client"."%");
        })->get();
        $designation  =   User::whereNotNull('designation')->where('type',"Client")->groupBy('designation')->pluck('designation');
        $user  =   User::with('projects')->where('type',"Client")->where('id',$id)->first(); 
        $projects  =   Project::  get(); 
        return view('admin.users.edit_client_users', compact('user','roles','designation','projects'));
    }

    public function lead_users()
    { 
        $users  =   User::with('projects')->where('designation',"LIKE","%lead%")->orWhere('designation',"LIKE","%manager%")->orWhere('designation',"LIKE","%director%")->get(); 
        return view('admin.users.lead_users', compact('users'));
    }

    public function edit_lead_user(Request $request,$id=null){
        // return $request;
        if($request->submit == "lead_submit"){
            $user   =   User::where('id',$request->user_id)->first();
            if($request->get('password'))
            $user->password   =   Hash::make($request->get('password'));                
            $user->type = 'User'; 
            $user->name = $request->name; 
            $user->HRMSID=$request->HRMSID; 
            $user->email=$request->email;                  
            $file_name = uniqid().'.jpg';
            if($request->hasFile('image')){    
                $request->file('image')->storeAs('user', $file_name, 'uploads');    
                $user->image = $file_name;    
            } $user->save(); 
            \DB::table('client_projects')->where('user_id',$user->id)->delete();
            if($request->projects){
                foreach($request->projects as $project){
                    \DB::table("client_projects")->insert([
                        'user_id' => $user->id,
                        'project_id' => $project
                    ]);
                }
            }
            
            return redirect()->route('lead_users')->with('success', "User update Successfully");                
        }
        $roles = Role::where('id',">",1)->where(function($query){
            $query->where("name","LIKE","%"."client"."%")->orwhere("name","LIKE","%"."client"."%");
        })->get();
        $designation  =   User::whereNotNull('designation')->where('type',"<>","Client")->groupBy('designation')->pluck('designation');
        $user  =          User::with('projects')->where('id',$id)->first(); 
        $projects  =   Project::get(); 
        return view('admin.users.edit_lead_user', compact('user','roles','designation','projects'));
    }
}
