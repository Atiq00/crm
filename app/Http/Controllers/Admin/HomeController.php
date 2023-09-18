<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\Department;
use App\Models\Priority;
use App\User;use DB;
use App\Models\Customer;use Auth;
use App\Models\SaleRecord;
use App\Models\SaleDss;
use App\Models\SaleMortgage;
use App\Models\SolarAustinPheonixSale;
use App\Models\HomeWarranty;
use App\Models\CannedMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.dashboard')
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // return Auth::user()->with('roles);
        if(auth()->user()->hasRole('EDDY')){
             
            $res = DB::table('eddy_sales')
            ->selectRaw("
                Count(Case when type='Inbound' THEN 1 ELSE NULL END)   as Inbound,
                Count(Case when type='Outbound' THEN 1 ELSE NULL END)  as Outbound,
                Count(Case when type='EddyEdu' THEN 1 ELSE NULL END)   as EddyEdu,

                Sum(Case when type='Inbound'  THEN billable_hours ELSE NULL END)   as InBillableHours,
                AVG(Case when type='Inbound'  THEN connect_percentage ELSE NULL END)  as InConnectPercentage,
                Sum(Case when type='Inbound'  THEN edu_transfer_rate ELSE NULL END)   as InEduTransferRate,
                Avg(Case when type='Inbound'  THEN edu_conv_percentage_of_total_calls ELSE NULL END)   as InEduConvTotalCalls,
                Sum(Case when type='Inbound'  THEN edu_transfers ELSE NULL END)   as InEduTransfers,
                Sum(Case when type='Inbound'  THEN edu_conversions ELSE NULL END)   as InEduConversions,


                Sum(Case when type='Outbound'  THEN billable_hours ELSE NULL END)   as OutBillableHours,
                AVG(Case when type='Outbound'  THEN connect_percentage ELSE NULL END)  as OutConnectPercentage,
                Sum(Case when type='Outbound'  THEN edu_transfer_rate ELSE NULL END)   as OutEduTransferRate,
                Avg(Case when type='Outbound'  THEN edu_conv_percentage_of_total_calls ELSE NULL END)   as OutEduConvTotalCalls,
                Sum(Case when type='Outbound'  THEN edu_transfers ELSE NULL END)   as OutEduTransfers,
                Sum(Case when type='Outbound'  THEN edu_conversions ELSE NULL END)   as OutEduConversions,


                Sum(Case when type='EddyEdu'  THEN billable_hours ELSE NULL END)   as EddyBillableHours,
                Sum(Case when type='EddyEdu'  THEN forms ELSE NULL END)  as forms,
                Sum(Case when type='EddyEdu'  THEN lts ELSE NULL END)   as lts,
                Avg(Case when type='EddyEdu'  THEN conv_percentage ELSE NULL END)   as conv_percentage,
                AVG(Case when type='EddyEdu'  THEN lt_percentage ELSE NULL END)   as lt_percentage,
                Sum(Case when type='EddyEdu'  THEN wlph ELSE NULL END)   as wlph

            ");

            if ($request->f_date)
                $res = $res->whereDate('sale_date',">=", $request->f_date);
            if ($request->t_date)
                $res = $res->whereDate('sale_date',"<=", $request->t_date);

            $data['totals'] = $res->get();

            $dates=''; $lastSevenDaysData=array();
            for($i=0;$i<=6;$i++){ 
                $data['date']=date('Y-m-d', strtotime("-$i days"));
                $data['eddy']    =  DB::table('eddy_sales')->whereDate("sale_date","=",date('Y-m-d', strtotime("-$i days")))->where('type','EddyEdu')->count();
                $data['inbound'] =  DB::table('eddy_sales')->whereDate("sale_date","=",date('Y-m-d', strtotime("-$i days")))->where('type','InBound')->count();
                $data['outbound'] = DB::table('eddy_sales')->whereDate("sale_date","=",date('Y-m-d', strtotime("-$i days")))->where('type','OutBound')->count(); 
                array_push($lastSevenDaysData,$data);
            }
            $data['lastSevenDaysData'] =$lastSevenDaysData;
            return view('admin.eddydashboard',$data);
        }
        if(auth()->user()->hasRole('MikeMeyerClient')){
            $data = $this->havaSu();
            return view('admin.havasu_dashboard', $data);
        }
        
        return !auth()->user()->hasRole('Super Admin') ? $this->agentDashboard() : $this->adminDashboard();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {

        $latest_tickets = Ticket::latest()->limit(5)->get();
        $pieChart['solar']=SaleRecord::count();
        $pieChart['mortgage']=SaleMortgage::count();
        $pieChart['homewarranty']=HomeWarranty::count();
        $pieChart['dss']=SaleDss::count();
        $dates=''; $lastSevenDaysData=array();
        for($i=1;$i<=7;$i++){ 

           $data['date']=date('D d-M-Y', strtotime("-$i days"));
           $data['solar_count']    = SaleRecord::whereDate("created_at","=",date('Y-m-d', strtotime("-$i days"))) ->count();
           $data['mortgage_count'] = SaleMortgage::whereDate("created_at","=",date('Y-m-d', strtotime("-$i days")))->count();
           $data['warranty_count'] = HomeWarranty::whereDate("created_at","=",date('Y-m-d', strtotime("-$i days")))->count();
           $data['dss_count'] = SaleDss::whereDate("created_at","=",date('Y-m-d', strtotime("-$i days")))->count();
           array_push($lastSevenDaysData,$data);
        }
        
        
        return view('admin.dashboard', compact('latest_tickets','pieChart','lastSevenDaysData'));
    }


    public function olddata(Request $request)
    {
        $data = SaleRecord::paginate(50); 

        return view('admin.olddata',compact('data'));

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function agentDashboard()
    {

        $latest_tickets = Ticket::where('user_id', auth()->user()->id)->latest()->limit(5)->get();
        
        $open_tickets = Ticket::where('user_id', auth()->user()->id)->where('status', 'open')->count();
        $total_tickets = Ticket::where('user_id', auth()->user()->id)->count();
        
        $unreplied_tickets = Ticket::where('user_id', auth()->user()->id)->where('status_reply', 'client_reply')->where('status', 'open')->count();

        return view('admin.agent_dashboard', compact('latest_tickets', 'open_tickets', 'total_tickets', 'unreplied_tickets'));
    }

    public function havaSu()
    {

        $data['leads_web_forms'] = SolarAustinPheonixSale::whereNotIn('type',['Phone_Call','Email'])->count();         
        $data['leads_other_src'] = SolarAustinPheonixSale::whereIn('type',['Phone_Call','Email'])->count();         
        $data['submission'] = SaleRecord::where('sol','1')->count();    
        return $data;    
        
    }
	
	public function testfunc(){
		echo "Test Case";
	}
}
