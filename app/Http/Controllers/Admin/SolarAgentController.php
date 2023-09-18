<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleRecord;
use App\Models\Project;
use DB;
use App\User;
use App\Models\Client;
use Auth;
use Doctrine\DBAL\Driver\IBMDB2\DB2Driver;
use Illuminate\Support\Facades\DB as FacadesDB;

class SolarAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query =  new SaleRecord();
        $query = DB::table('sale_records')->selectRaw(' users.id as userID, users.camp_status as campstatus, users.pseudo_name as Pseudonym , users.reporting_to_name as ReportingTo ,
        users.campaign_hire_date as Campaign_Hire_Date,
        count(sale_records.user_id) as SaleCount ,abs(DATEDIFF(users.campaign_hire_date , CURRENT_DATE())) AS AgentTenure
        ,projects.name as ProjectName , users.joining_date as hiredate
        ,count(CASE WHEN sale_records.client_status = "billable" THEN 1 ELSE NULL END) as booked
        ,count(CASE WHEN sale_records.client_status="pending" THEN 1 ELSE NULL END) as Pending
        ,count(CASE WHEN sale_records.client_status="not-billable" THEN 1 ELSE NULL END) as NotBill
        ,sale_records.created_at')
        ->join('users','users.HRMSID','=','sale_records.user_id')
        ->join('projects','projects.project_code','=','sale_records.project_code')
        ->Where('sale_records.project_code','=','PRO0074')
        ->groupBy('users.name');
        // dd($request);
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('sale_records.created_at', '>=', $request->start_date);
                $query = $query->whereDate('sale_records.created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('sale_records.created_at', $request->start_date);
            }
        }
        if ($request->has('pseudo_name')) {
            if (!empty($request->pseudo_name)) {
                $query = $query->where('users.pseudo_name', 'LIKE', "%{$request->pseudo_name}%");
            }
        }

        $solaragent = $query->get();

        // $solaragent::select("Select u.pseudo_name,u.name,count(sr.user_id)
        // as Sale_Count,p.name as project_name,sr.project_code
        // from users u inner join sale_records sr on(u.HRMSID=sr.user_id)
        // INNER join projects p
        // On(p.project_code=sr.project_code)
        // where cast(sr.created_at as date)='2023-02-10' and sr.project_code='PRO0033' GROUP by u.name");

        return view ('admin.SolarAgentCount.index',compact('solaragent'));




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $user =  User::where('id',$id)->first();

        return view("admin.SolarAgentCount.edit",compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {

        $user = User:: findOrFail($user);
        $request->validate([
            'campaign_hire_date' => 'required',
        ]);
        $userUpdate = \DB::table('users')->where('id',$user->id)->update(['campaign_hire_date'=>$request->campaign_hire_date,'camp_status'=>$request->camp_status]);


        // $userUpdate->campaign_hire_date = $request->campaign_hire_date;
        // $userUpdate->save();

        return redirect()->route('agent.index')
                        ->with('success','Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
