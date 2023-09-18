<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\UkDebt;
use App\Export\UserExport;
use App\Exports\UkdebtExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class UkDebtController extends Controller
{
    public function __construct()
    {
        view()->share(
            'site',
            (object) [
                'title' => 'Uk-Debt',
            ],
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   //
        $query = new UkDebt();
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }
            $uk = $query->paginate(10);
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
            $uk = $query->paginate(100);
        }
        $uk = $query->with('user')->latest()->get();

        return view('admin.ukdebt.index', compact('uk'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.ukdebt.create');
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
        $request->validate([
            'first_name' => 'required',
            'phone' => 'required',
        ]);

        UkDebt::create($request->all());
        Session::flash('success', 'Record Added Successfylly!');
        return redirect()
            ->route('ukdebt.index')
            ->with('Sucees');
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
        return view('admin.ukdebt.show', compact('uk'));
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
