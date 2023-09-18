<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HomeWarrantyExport;
use Carbon\Carbon;
use App\Models\SaleMortgage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Auth; 

class AllDebSheatExternalController extends Controller
{
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "alldebshea_external"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('alldebshea_external.index'); 
        $query = new SaleMortgage;
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
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
            $alldebshea_external = $query->paginate(1000);
        }
        else{
			$query = $query->whereDate('created_at', '=', date('Y-m-d'));
		}
        $alldebshea_external = $query->with('project','client')->where('project_code','PRO0204')->latest()->paginate(1000);

        return view('admin.alldebtshea.index',compact('alldebshea_external'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('alldebshea_external.create'); 
        return view('admin.alldebtshea.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $this->authorize('alldebshea_external.store'); 
        $check = SaleMortgage::where('phone',$request->phone)->first();
        if($check ){ 
            Session::flash('error', 'Phone no already used!');
            return redirect()->back()->with('error','Phone no already used');
        }
        $request->merge([ 
            'client_code' => "CUS-100035",
            'project_code' => "PRO0204",
        ]);
        SaleMortgage::create($request->all());
        Session::flash('success', 'Record Added Successfylly!');
        return redirect()->route('alldebshea_external.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SaleMortgage $alldebshea_external)
    {
        $this->authorize('alldebshea_external.show'); 
        return view('admin.alldebtshea.show',compact('alldebshea_external'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // return view('admin.alldebtshea.edit',compact('alldebshea_external'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleMortgage $alldebshea_external)
    {
        $this->authorize('alldebshea_external.update'); 
        $alldebshea_external->update($request->all());
        Session::flash('success', 'Record updated successfully!');
        return redirect()->route('alldebshea_external.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleMortgage $alldebshea_external)
    {
        $this->authorize('alldebshea_external.delete'); 
        $alldebshea_external->delete();
        Session::flash('success', 'Record deleted successfully!');
        return redirect()->back();
    }

}
