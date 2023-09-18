<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\TBBSTATS;
use App\Export\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
class TBBStatsControllers extends Controller
{
    public function __construct()
    {
        view()->share(
            'site',
            (object) [
                'title' => 'TBB-Stats',
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

        $query = new TBBSTATS();
        $query1 = new TBBSTATS();
        $query2= new TBBSTATS();
        $query1 = $query1
        ->selectRaw(
            'id,agent_name as AgentName,package_request_count as p_r_count,cruise_request_count as cr_r_count, chat_request_count as c_r_count, quotation_id as q_t,
    sum(package_request_count+cruise_request_count+chat_request_count) as t_p_r_count, cast(created_at as date) as date,avg_time_request as a_t_r
    ,avg(package_request_count+cruise_request_count+chat_request_count)/3 as avg',
        )
        ->groupBy('AgentName');
        $query = $query->selectRaw('avg(package_request_count+cruise_request_count+chat_request_count)/3 as avg , sum(package_request_count+cruise_request_count+chat_request_count) as totalcount');
        $query2= $query2->selectRaw('agent_name as agent, MAX(package_request_count+cruise_request_count+chat_request_count) AS max_value')
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

        $tbb2 = $query2->get();
        $tbb1 = $query1->paginate(100);
        $tbb = $query->paginate(100);

         //return $tbb;
        return view('admin.tbbstats.index', compact('tbb', 'tbb1','tbb2'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('HRMSID', '267109')->get();
        return view('admin.tbbstats.create', compact('users'));
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

        TBBSTATS::create($request->all());

        return redirect()
            ->route('tbb.create')
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
