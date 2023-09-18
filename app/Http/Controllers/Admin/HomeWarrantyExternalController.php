<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HomeWarrantyExport;
use Carbon\Carbon;
use App\Models\HomeWarrantyExternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Http\Requests\HomeWarrantyRequest;

class HomeWarrantyExternalController extends Controller
{
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "home-warranty-external"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('homewarrantyexternal.index'); 
        $query = new HomeWarrantyExternal;
        if ($request->has('start_date') || $request->has('end_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }elseif (!empty($request->start_end)) {
                $query = $query->whereDate('created_at', $request->start_end);
            }
            if(Auth::user()->hasRole('HomeWarrantyClient')){
                $project_codes = User::with('projects')->where('id',Auth::user()->id)->get()->pluck('projects')->flatten()->pluck('project_code');
                $query = $query->whereIn('project_code',$project_codes);
            }
            $home_warranty_external = $query->paginate(1000);
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
            $home_warranty_external = $query->paginate(1000);
        }
        else{
			$query = $query->whereDate('created_at', '=', date('Y-m-d'));
		}
        $home_warranty_external = $query->with('project','client')->where('type','BechMark')->latest()->paginate(1000);

        return view('admin.homewarrantyexternal.index',compact('home_warranty_external'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.homewarrantyexternal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        // $check = HomeWarrantyExternal::where('phone',$request->phone)->where('status',"!=","Unsuccessful Transfer")->first();
        // if($check){
        //     return redirect()->route('homewarrantyexternal.create')->with('error','This Phone No is already used.');
        // }
        // if($request->record_id<=0){
        //     return redirect()->route('homewarrantyexternal.create')->with('error',"RecordID Required");
        // }
        $check = HomeWarrantyExternal::where('phone',$request->phone)->first();
        if($check ){ 
            Session::flash('error', 'Phone no already used!');
            return redirect()->back()->with('error','Phone no already used');
        }
        $request->merge([
            'type' => "BechMark",
            'client_code' => "CUS-100077",
            'project_code' => "PRO0184",
        ]);
        HomeWarrantyExternal::create($request->all());
        Session::flash('success', 'Record Added Successfylly!');
        return redirect()->route('homewarrantyexternal.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HomeWarrantyExternal $home_warranty_external)
    {
        return view('admin.homewarrantyexternal.show',compact('home_warranty_external'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // return view('admin.homewarrantyexternal.edit',compact('home_warranty_external'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeWarrantyExternal $home_warranty_external)
    {
        $home_warranty_external->update($request->all());
        Session::flash('success', 'Record updated successfully!');
        return redirect()->route('homewarrantyexternal.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeWarrantyExternal $home_warranty_external)
    {
        $home_warranty_external->delete();
        Session::flash('success', 'Record deleted successfully!');
        return redirect()->back();
    }

}
