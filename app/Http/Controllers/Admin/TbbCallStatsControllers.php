<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\TBBCALLSTATS;
use App\Export\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
class TBBCallStatsControllers extends Controller
{
    public function __construct()
    {
        view()->share(
            'site',
            (object) [
                'title' => 'TBB-CALL-Stats',
            ],
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $query = new TBBCALLSTATS();
        $query1 = new TBBCALLSTATS();
        $query2= new TBBCALLSTATS();
        $query1 = $query1
        ->selectRaw(
            'id,agent_name as AgentName,no_of_call_count as n_r_count,quotation_count as quo_r_count, bookings_count as b_r_count,
    sum(no_of_call_count+quotation_count+bookings_count) as t_p_r_count, cast(created_at as date) as date,avg_time_request as a_t_r
    ,avg(no_of_call_count+quotation_count+bookings_count)/3 as avg',
        )
        ->groupBy('AgentName');
        $query = $query->selectRaw('avg(no_of_call_count+quotation_count+bookings_count)/3 as avg , sum(no_of_call_count+quotation_count+bookings_count) as totalcount');
        $query2= $query2->selectRaw('agent_name as agent, MAX(no_of_call_count+quotation_count+bookings_count) AS max_value')
        ->groupBy('agent')->orderBy('max_value','DESC')->limit(1);
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }

        }
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query1 = $query1->whereDate('created_at', '>=', $request->start_date);
                $query1= $query1->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query1 = $query1->whereDate('created_at', $request->start_date);
            }

        }
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query2 = $query2->whereDate('created_at', '>=', $request->start_date);
                $query2= $query2->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query2 = $query2->whereDate('created_at', $request->start_date);
            }

        }

        $tbbcall2 = $query2->get();
        $tbbcall1 = $query1->paginate(100);
        $tbbcall = $query->paginate(100);

         //return $tbb;
        return view('admin.tbbcallstats.index', compact('tbbcall', 'tbbcall1','tbbcall2'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('HRMSID', '267109')->get();
        return view('admin.tbbcallstats.create', compact('users'));
    }

    public function get_agents($HRMSID)
    {
        $users = User::where('reporting_to_id', $HRMSID)->get();
        $data = $users->map(function ($user) {
            return [
                'HRMSID' => $user->HRMSID,
                'name' => $user->name,
            ];
        });
        return response()->json(['data' => $data]);
    }
    public function get_agent_name($HRMSID)
    {
        $user = User::where('HRMSID', $HRMSID)->first();
        $data = [
            'name' => $user->name,
            'reporting_to_name' => $user->reporting->name,
        ];
        return response()->json(['data' => $data]);
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

        TBBCALLSTATS::create($request->all());

        return redirect()
            ->route('tbbcall.create')
            ->with('success');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UkDebt $uk)
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
        //
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
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UkDebt $uk)
    {
        //
    }

    public function exportUkdebtSalesReport(Request $request)
    {
        $now = now();
        return Excel::download(new UkdebtExport($request), "UkDebt-Sales-Report-{$now->toString()}.xlsx");
    }
}
