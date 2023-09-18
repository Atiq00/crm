<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CRU;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Exports\CRUExport;
use Maatwebsite\Excel\Facades\Excel;

class CruController extends Controller
{

    public function __construct()
    {
        view()->share(
            'site',
            (object) [
                'title' => 'DSS',
            ],
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportcruSalesReport(Request $request)
    {
        $now = now();
        return Excel::download(new CRUExport($request), "CRU-Sales-Report-{$now->toString()}.xlsx");
    }
    public function exportcruSalesReportCount(Request $request)
    {
        $now = now();
        return Excel::download(new CRUCountExport($request), "CRU-Sales-Report-Count-{$now->toString()}.xlsx");
    }
    public function index(Request $request)
    {

        //dd($request);
        $query = new CRU();
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }
            $cru = $query->select('id','agent_name','record_id')->selectRaw('min(created_at) as date')->groupby('record_id')->orderBy('id','desc')->paginate(100);
        }

        if ($request->has('agent_name')) {
            if (!empty($request->agent_name)) {
                $query = $query->where('agent_name', 'LIKE', "%{$request->agent_name}%");
            }
            $cru = $query->select('id','agent_name','record_id')->selectRaw('min(created_at) as date')->groupby('record_id')->orderBy('id','desc')->paginate(100);
        }

        $cru = $query->select('id','agent_name','record_id')->selectRaw('min(created_at) as date')->groupby('record_id')->orderBy('id','desc')->paginate(100);

        return view('admin.CRU.index', compact('cru'));
    }

    public function count(Request $request)
    {
        //dd($request);
       $query = new CRU;

       if ($request->has('start_date')) {
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $query = $query->whereDate('created_at', '>=', $request->start_date);
            $query = $query->whereDate('created_at', '<=', $request->end_date);
        } elseif (!empty($request->start_date)) {
            $query = $query->whereDate('created_at', $request->start_date);
        }

       $cruc = $query->select('id','agent_name')->selectRaw('count(Distinct record_id) as count , min(created_at) as date')
       ->groupby('agent_name')->orderBy('id','desc')->paginate(100);
    }

       $cruc = $query->select('id','agent_name')->selectRaw('count(Distinct record_id) as count , min(created_at) as date')
           ->groupby('agent_name')->orderBy('id','desc')->paginate(100);

        return view('admin.CRU.count',compact('cruc'));
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
    public function destroy($id)
    {
        //
    }
}
