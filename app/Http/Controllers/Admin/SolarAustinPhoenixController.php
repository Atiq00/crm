<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Solar; use Mail;
use App\Traits\SolarPosting;
use App\Models\SolarAustinPheonixSale;
use App\Models\SaleRecord;
use App\Models\Project;use DB;
use App\User;use App\Http\Requests\SolarRequest;
use App\Exports\ExportSolar; 
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Client;use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class SolarAustinPhoenixController extends Controller
{

    use Solar,SolarPosting;
    
    
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "Solars"
        ]);
    }
   
    

    public function index(Request $request)
    {         
        $this->authorize('austinphoenix.index');  
        $search = @$request->search;
        $clients = Client::where('campaign_id',2)->get();
        $projects = Project::whereIn('client_id',$clients->pluck('id'))->get();
        $start_date = @$request->start_date;
        $end_date = @$request->end_date;
        $solars  =   new SolarAustinPheonixSale();         
        $solars = $solars->search(@$request->search,@$request->start_date,@$request->end_date,@$request->client_id,@$request->project_id,@$request->user_id,@$request->reporting_to);
        $solars = $solars->where(function($query){
            $query->where('status',"Accept")->orWhereNull('status');
        })->orderby('id','DESC' )->paginate(100);
        return view('admin.solar_austin_phoenix.index',compact('solars','projects','clients'));

    }

     

    public function create($id=null)
    {
        if(@$_GET['record_id']){
            $lead =  SolarAustinPheonixSale::where('record_id',$_GET['record_id'])->first();
            $states = DB::table("electric_provider")->groupBy('state')->get();
            $this->authorize('austinphoenix.create'); 
            $clients = Client::where('campaign_id',2)->pluck('id');
            $projects = Project::whereIn('client_id',$clients)->get();
            return view('admin.solar_austin_phoenix.create',compact('clients','lead','projects','states'));
        }else{ 
            $states = DB::table("electric_provider")->groupBy('state')->get();
            $this->authorize('austinphoenix.create'); 
            $clients = Client::where('campaign_id',2)->pluck('id');
            $projects = Project::whereIn('client_id',$clients)->get();
            return view('admin.solar_austin_phoenix.create_other_sr',compact('clients','projects','states'));
        }
        
    }

    
    public function store(SolarRequest $request)
    { 
		// return $request;
        if($request->record_id<=0){
            return redirect()->back()->with('error',"RecordID Required");
        }  
        DB::connection('mysql')->beginTransaction();
        try{ 
            
            $check =    DB::table('sale_records')->where('phone',$request->phone)->whereDate('created_at',"<=",date('Y-m-d',strtotime('-90 days')) )->first();                    
            $check1 =   DB::table('sale_records')->where('record_id',$request->record_id)->first(); 
            $checkOld = DB::table('phone_numbers')->where('phone',$request->phone)->first();
            if($check || $checkOld || $check1){ 
               return redirect()->back()->with('error','Phone no already used');
            } 
            $data = $request->all();
            $res = $this->InsertSaleRecord($data); 
            $res = $this->postingUrl($request->clients,$data,$res);  
            DB::commit();	
            SolarAustinPheonixSale::where('record_id',$request->record_id)->limit(1)->update(['status'=>"Closed"]);		
            return redirect()->route('austinphoenix_salesheet')->with('success',"Post Successfully");
        }catch(\Exception $e){
            DB::connection('mysql')->rollback();  
            if(Auth::user()->hasRole('Super Admin')){
                return redirect()->back()->with('error',$e->getMessage());
              }
            return redirect()->back()->with('error',"Internal Server Error");
        }
    }
	
    public function store_other(SolarRequest $request) { 
        // return $request;
        DB::connection('mysql')->beginTransaction();
        try{     
            $data = $request->all(); 
            $max = DB::table('solar_pci')->max('record_id');
            $max = $max+10;    
            $Create = new SolarAustinPheonixSale(); 
            $Create->record_id = @$max;
            $Create->first_name = @$data['first_name'];
            $Create->last_name = @$data['last_name']; 
            $Create->phone_number = @$data['phone']; 
            $Create->street_address = @$data['address'];  
            $Create->zip_code = @$data['zip_code'];  
            $Create->city = @$data['city'];
            $Create->state = @$data['state'];
            $Create->home_owner = @$data['homeowner'];
            $Create->email = @$data['email'];  
            $Create->utility_provider = @$data['electric_provider']; 
            $Create->average_monthly_bill = @$data['electric_bill_monthly'];   
            $Create->credit_score = @$data['credit_score'];   
            $Create->msg = @$data['notes'];   
            $Create->date = @$data['app_date_time'];
            $Create->property = @$data['property'];
            $Create->type = @$data['type'];
            $Create->save();
            DB::commit();		
            return redirect()->back()->with('success',"Post Successfully");
        }catch(\Exception $e){
            DB::connection('mysql')->rollback();  
            if(Auth::user()->hasRole('Super Admin')){
                return redirect()->back()->withInput()->with('error',$e->getMessage());
            }
            return redirect()->back()->withInput()->with('error',"Internal Server Error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		// $this->authorize('austinphoenix.show');  
        // $data = SolarAustinPheonixSale::where('id',$id)->first();
        // return view('admin.solar_austin_phoenix.view',compact('data'));
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
		// $this->authorize('austinphoenix.edit');  
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
		$this->authorize('austinphoenix.update'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		// $this->authorize('austinphoenix.destroy'); 
        // SolarAustinPheonixSale::where('id',$id)->delete();
        // return redirect()->back()->with("success","Disabled successfully");
    }
    public function devsolar()
    {    
        // $states = DB::table("electric_provider")->groupBy('state')->get();
        // $this->authorize('austinphoenix.create'); 
        // $clients = Client::where('campaign_id',2)->pluck('id');
        // $projects = Project::whereIn('client_id',$clients)->get();
        // return view('admin.solar_austin_phoenix.devCreate',compact('clients','projects','states'));
    }

    public function austinphoenix_salesheet(Request $request){
        $userIds = SaleRecord::pluck('user_id');
        $repIds =  DB::table('users')->groupBy('reporting_to_id')->pluck('reporting_to_id');
        $users = DB::table('users')->whereIn('HRMSID',$userIds)->where('HRMSID',">",0)->get();
        $usersRepTo = DB::table('users')->whereIn('HRMSID',$repIds)->where('HRMSID',">",0)->get();

		$user = auth()->user(); 
        if($request->export){
            return Excel::download(new ExportSolar(@$request->start_date,@$request->end_date,
			@$request->search,@$request->client_id,@$request->project_id,Auth::user()->id), 'ExportSolar.xlsx');
        }
        $states = DB::table("electric_provider")->get();
        $clients = Client::where('campaign_id',2)->get();
        $projects = Project::whereIn('client_id',$clients->pluck('id'))->get();      
        $search = @$request->search;
        $start_date = @$request->start_date;
        $end_date = @$request->end_date;
        $solars  =   SaleRecord::with('user','client')->where('campaign_id',"2");
        if(Auth::user()->hasRole('SolarClient')){			
            $project_codes = User::with('projects')->where('id',Auth::user()->id)->get()->pluck('projects')->flatten()->pluck('project_code');
            $solars  =   $solars->whereIn('project_code',$project_codes);
        } 
        if(($request->search) || ($request->start_date) || ($request->end_date) || ($request->client_id) || ($request->project_id) || (@$request->user_id) || (@$request->reporting_to) )
        {
            $solars = $solars->search($request->search,@$request->start_date,@$request->end_date,@$request->client_id,@$request->project_id,@$request->user_id,@$request->reporting_to);
        } 
        $solars = $solars->where('sol',"1")->where('project_code',"PRO0095")->orderby('id','DESC' )->paginate(100);
        return view('admin.solar_austin_phoenix.salesheet',compact('solars','clients','projects','states','users','usersRepTo'));
    }
    
    
}
