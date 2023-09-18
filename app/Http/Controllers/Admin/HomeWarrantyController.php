<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HomeWarrantyExport;
use Carbon\Carbon;
use App\Models\HomeWarranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Http\Requests\HomeWarrantyRequest;

class HomeWarrantyController extends Controller
{
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  "home-warranties"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$user = auth()->user();
		$raw_result = DB::select( DB::raw("SELECT * FROM model_has_roles WHERE model_id = '$user->id'") );
		$roleid = $raw_result[0]->role_id;
		
		if (!in_array($roleid, array(11,12,1,18,17,43,46))) {
			return redirect()->route('home-warranties.create')->with('error',"Access Denied");
		}
		$this->authorize('home-warranties.index'); 
		
        $query = new HomeWarranty;
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
            $home_warranties = $query->paginate(100);
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
            $home_warranties = $query->paginate(100);
        }
        else{
			$query = $query->whereDate('created_at', '=', date('Y-m-d'));
		}
        $home_warranties = $query->with('project','client')->latest()->paginate(100);

        return view('admin.home-warranties.index',compact('home_warranties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.home-warranties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeWarrantyRequest $request)
    {
        $data = $request->all();
        $check = HomeWarranty::where('phone',$request->phone)->where('status',"!=","Unsuccessful Transfer")->first();
        if($check){
            return redirect()->route('home-warranties.create')->with('error','This Phone No is already used.');
        }
        if($request->record_id<=0){
            return redirect()->route('solars.create')->with('error',"RecordID Required");
        }
        $data["First_Name"]  = $request->first_name;
        $data["Last_Name"]   = $request->last_name;
        $data["City"]        = $request->city;
        $data["Zip"]         = $request->zip_code;
        $data["State"]       = $request->state;
        $data["Address"]     = $request->address;
        $data["Phone"]       = $request->phone;

        $data["SRC"]  = "PAK_HW";
        $data["Key"]  = "286847303cb3ed156318127a9df491c784c6661c016ada6ae97672a9c7fcab57";
        $data["API_Action"]  = "pingPostLead";
        $data["Mode"]  = "full";
        $data["TYPE"]  = "105";
        $data["Landing_Page"]  = "www.landing.com";
        $data["Lead_ID"]  = "57649957771";
        $data["IP_Address"]  = "75.2.92.149";
        $data["Force_IPR_Buyer"]  = "1";

        $request->merge([
            'reporting_to_name' => Auth::user()->reporting_to_name,        
            'reporting_to' =>      Auth::user()->reporting_to_id,         
            'designation' =>       Auth::user()->load('reporting')->designation,       
            'campaign_name' =>     Auth::user()->campaign
        ]);
         

        HomeWarranty::create($request->all());
        $lastrecord = HomeWarranty::latest('id')->first();
        if($request->client == "HW CH less then 59" || $request->client == "HW CH 60 Years")
         {
            $queryString = http_build_query($data);
            $url="https://leadsordered.leadportal.com/new_api/api.php?".$queryString;  //url of 2nd website where data is to be send
            $postdata = $data;
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type', 'application/json'));
            $result = curl_exec ($ch);
             //echo $result;
            curl_close($ch);

            DB::table('home_warranties')
            ->where('id', $lastrecord->id)
            ->update([
                'post_data'     => $data,
                'post_response' => $result
            ]);
        }
        Session::flash('success', 'Record Added Successfylly!');
        return redirect()->route('home-warranties.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HomeWarranty $home_warranty)
    {
        return view('admin.home-warranties.show',compact('home_warranty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeWarranty $home_warranty)
    {
        return view('admin.home-warranties.edit',compact('home_warranty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeWarranty $home_warranty)
    {
        $home_warranty->update($request->all());
        Session::flash('success', 'Record updated successfully!');
        return redirect()->route('home-warranties.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeWarranty $home_warranty)
    {
        $home_warranty->delete();
        Session::flash('success', 'Record deleted successfully!');
        return redirect()->back();
    }
    public function exportHomeWarrantySalesReport(Request $request)
    {
        $now = now();
        return Excel::download(new HomeWarrantyExport($request), "Home-Warranty-Sales-Report-{$now->toString()}.xlsx");
    }
}
