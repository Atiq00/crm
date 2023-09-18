<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleMortgage;
use App\Models\Client;use Auth;
use App\Models\Project;
use App\User;use DB;
use App\Traits\Mortgage;
use App\Traits\MortgagePosting;   
use App\Exports\ExportMortgage; 
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class MortgageController extends Controller
{
    use Mortgage;
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "Mortgage"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
 
		$userIds = SaleMortgage::pluck('user_id');
        $users = DB::table('users')->whereIn('HRMSID',$userIds)->where('HRMSID',">",0)->get();
        if($request->export){ 
          return Excel::download(new ExportMortgage(@$request->start_date,@$request->end_date,
          @$request->search,@$request->client_id,@$request->project_id), 'ExportMortgage.xlsx');
        }
        $clientid = Client::where('campaign_id',3)->pluck('id');$clients  = Client::where('campaign_id',3)->get();                 
        $this->authorize('mortgages.index');
        if(auth()->user()->hasRole("MortgageClient")){
            $project_codes = User::with('projects')->where('id',auth()->user()->id)->get()->pluck('projects')->flatten()->pluck('project_code');
            $projects = Project::whereIn('client_id',$clientid)->whereIn('project_code',$project_codes)->get();
        }else{
            $projects = Project::whereIn('client_id',$clientid)->get();  
        }
         
        $mortgages  =   SaleMortgage::with('user','client');
        if(Auth::user()->hasRole('MortgageClient')){
            $project_codes = User::with('projects')->where('id',Auth::user()->id)->get()->pluck('projects')->flatten()->pluck('project_code');
            $mortgages = $mortgages->where('campaign_id',"3")->whereIn('project_code',$project_codes);
        } 
        if(($request->search) || ($request->start_date) || ($request->end_date) || ($request->client_id) || ($request->project_id) || (@$request->user_id) || (@$request->reporting_to))
        {
            $mortgages = $mortgages->search($request->search,@$request->start_date,@$request->end_date,@$request->client_id,@$request->project_id,@$request->user_id,@$request->reporting_to);
        } 
        $mortgages = $mortgages->orderby('id','DESC' )->paginate(100); 

       
        return view('admin.mortgage.index',compact('mortgages','clients','projects','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('mortgages.create'); 
        $clientid = Client::where('campaign_id',3)->pluck('id'); 
        $clients = Project::whereIn('client_id',$clientid)->get(); 
        return view('admin.mortgage.create',compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
		 
        if($request->record_id<=0){
            return redirect()->route('solars.create')->with('error',"RecordID Required");
        }
        DB::connection('mysql')->beginTransaction();
        try{
            $last_three_month = \Carbon\Carbon::now()->subMonth(4);
            $this_month = \Carbon\Carbon::now();         
            $check = SaleMortgage::where('phone',$request->phone)->whereNull('deleted_at')->whereBetween('created_at',[$last_three_month,$this_month])->first();         		 
            $check1 =   DB::table('sale_mortgages')->whereNull('deleted_at')->where('record_id',$request->record_id)->first(); 
            $checkOld = DB::table('phone_numbers')->where('phone',$request->phone)->first();
            if($check || $checkOld || $check1){ 
                return redirect()->back()->with('error','Phone no already used');
            } 
            if($request->clients == "PRO0096"){
                $request->validate([
                    'first_name'=>"required",
                    'last_name'=>"required",
                    'phone'=>"required",
                    'clients'=>"required",
                ]);
            }else{
                $request->validate([
                    'first_name'=>"required",
                    'last_name'=>"required",
                    'phone'=>"required",
                    'clients'=>"required",
                    'record_id'=>"required",
                ]);
            }
            
        
            $data = $request->all();
            $res = $this->InsertSaleRecord($data);
            $res = $this->postingUrl($request->clients,$data,$res);         
            DB::commit();
            return redirect()->route('mortgages.create')->with('success',"Post Successfully");
        }catch(\Exception $e){
            DB::connection('mysql')->rollback(); 
            DB::table('error_logs')->insert([
                'project_code' =>$request->clients,
                'error' => json_encode($e->getMessage())
            ]);
			if(Auth::user()->hasRole('Super Admin')){
				return redirect()->route('mortgages.create')->with('error',$e->getMessage());
			}
            
            return redirect()->route('mortgages.create')->with('error',"internal server error");
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
		$this->authorize('mortgages.show'); 
        $data = SaleMortgage::with('project')->where('id',$id)->first();

        $postSapData['record_id']=@$data->record_id; 
        $url="https://qmsv.touchstone-communications.com/api/get-voice-audits";   
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_POSTFIELDS,json_encode($postSapData));
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec ($ch);  
        curl_close($ch);
        $result = json_decode ($result); 
        // echo "<pre>";print_r($result);exit;
        $result = $result->data;
        return view('admin.mortgage.view',compact('data','result'));
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
		$this->authorize('mortgages.edit'); 
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
		$this->authorize('mortgages.update'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$this->authorize('mortgages.destroy'); 
        SaleMortgage::where('id',$id)->delete();
        return redirect()->back()->with("success","Disabled successfully");
    }

    public function export(){
        return Excel::download(new ExportMortgage, 'ExportMortgage.xlsx');
    }
}
