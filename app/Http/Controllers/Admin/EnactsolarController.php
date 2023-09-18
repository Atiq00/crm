<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Solar; use Mail;
use App\Traits\SolarPosting;
use App\Models\SaleRecord;
use App\Models\Project;use DB;
use App\User;use App\Http\Requests\SolarRequest;
use App\Exports\ExportSolar; 
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Client;use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class EnactsolarController extends Controller
{

    use Solar,SolarPosting;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "Solars"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        echo "Index Page";

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.enactsolar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
		 
		\DB::table('sale_records')->insert([
			'record_id' => "Enact".rand(10009,99999).rand(100,999),			
			'city' => $request->city,
			'client_code' => "CUS-100065",
			'project_code' => "PRO0155",
			'electric_bill' => $request->electric_bill,
			'email' => $request->email,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'phone' => $request->phone,
			'state' => $request->state,		
			'address' => $request->street,
			'zipcode' => $request->zipcode,			
			'user_id' => auth()->user()->HRMSID,
			'campaign_id'=>2

		]);return $request;
    }
	
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$this->authorize('solars.show');  
        $data = SaleRecord::where('id',$id)->first();
        return view('admin.solar.view',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$this->authorize('solars.edit');  
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
        //
		$this->authorize('solars.update'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		 
    }
    public function devsolar($id)
    {    
         
    }
	
	public function enactsolar_create()
    {     
        $this->authorize('solars.create');  
        return view('admin.enactsolar.create');		
    }
    
    
}
