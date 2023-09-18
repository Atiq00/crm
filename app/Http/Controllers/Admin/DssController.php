<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\SaleDss;
use App\Models\RecordDss;
use App\Export\UserExport;
use App\Exports\DSSExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DssController extends Controller
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
    public function index(Request $request)
    {
        //

        $query = new SaleDss();
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }
            $dsses = $query->paginate(10);
        }

        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
            $dsses = $query->paginate(10);
        }

        $dsses = $query
            ->with('user')
            ->latest()
            ->get();
        return view('admin.dss.index', compact('dsses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.dss.create');
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
            //'last_name'=>"required",
            'phone' => 'required',
        ]);

        $input = $request->all();
        //  $Question_1 = isset($_POST['Question_1']) && is_array($_POST['Question_1']) ? $_POST['Question_1'] : [];
        //  $vpn1 =implode(',', $Question_1);

        $input['question_1'] = @$request->input('question_1') ? implode(',', @$request->input('question_1')) : '';
        $input['question_2'] = @$request->input('question_2') ? implode(',', @$request->input('question_2')) : '';
        SaleDss::create($input);
        Session::flash('success', 'Record Added Successfylly!');
        return redirect()
            ->route('dss.index')
            ->with('Sucees');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SaleDss $dss)
    {
        //

        return view('admin.dss.show', compact('dss'));
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
    public function destroy(SaleDss $dsses)
    {
        //
        $dsses->delete();
        Session::flash('success', 'Record deleted successfully!');
        return redirect()->back();
    }
    public function get_record_id($id)
    {
        $records = RecordDss::findOrFail($id);
        $data = [
            'first_name' => $records->first_name,
            'last_name' => $records->last_name,
            'id' => $records->id,
            'address' => $records->address,
            'city' => $records->city,
            'state' => $records->state,
            'zipcode' => $records->zipcode,
            'phone' => $records->phone,
            'email' => $records->email,
            'customer_no' => $records->customer_no,
            'area' => $records->area,
            'customer_name' => $records->customer_name,

            // 'client_id'=>$records->client_id,
            // 'campaign_id'=>$records->campaign_id,
        ];

        return response()->json(['data' => $data]);
    }

    public function linechart(Request $request)
    {
        $start_date = @$request->start_date;
        $end_date = @$request->end_date;
        $data = [];
        if ($request->start_date && $request->end_date) {
            $amazon = SaleDss::where('question_1', 'LIKE', '%Amazon%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $beckers = SaleDss::where('question_1', 'LIKE', '%Beckers%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $lackshore = SaleDss::where('question_1', 'LIKE', '%Lackshore%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $kaplan = SaleDss::where('question_1', 'LIKE', '%Kaplan%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $discount_school_supply = SaleDss::where('question_1', 'LIKE', '%Discountschoolsupply%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $school_speciality = SaleDss::where('question_1', 'LIKE', '%Schoolspeciality%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $oriental_trading = SaleDss::where('question_1', 'LIKE', '%OrientalTrading%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $use_multiple_vendor = SaleDss::where('question_1', 'LIKE', '%UsemultipleVendor%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $others_question_1 = SaleDss::select('others_question_1')
                ->where('others_question_1', '!=', 'NULL')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_1 = SaleDss::where('question_3_1', 'LIKE', '%REFURBISHING%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_1_7 = SaleDss::where('question_3_1', 'LIKE', '%NEW ADDITION%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_2_1 = SaleDss::where('question_3_2', 'LIKE', '%1-3 months%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_2_2 = SaleDss::where('question_3_2', 'LIKE', '%3-6 months%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_2_3 = SaleDss::where('question_3_2', 'LIKE', '%6-9 months%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_2_4 = SaleDss::where('question_3_2', 'LIKE', '%A year%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_2_5 = SaleDss::where('question_3_2', 'LIKE', '%Not Yet Defined%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_3_2_6 = SaleDss::where('question_3_2', 'LIKE', '%No info%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();

            $question_3 = SaleDss::Where('question_3','LIKE','%Yes%')
            ->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->get();

            $question_3_1_1 = SaleDss::Where('question_3','LIKE','%No%')
            ->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->get();

            $question_4 = SaleDss::where('question_4', 'LIKE', '%Yes%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $question_4_1 = SaleDss::where('question_4', 'LIKE', '%No%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $pricing = SaleDss::where('question_2', 'LIKE', '%Pricing%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $lack_of_products = SaleDss::where('question_2', 'LIKE', '%Lackofproducts%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $fast_shipping = SaleDss::where('question_2', 'LIKE', '%FastShipping%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $free_shipping = SaleDss::where('question_2', 'LIKE', '%FreeShipping%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $quality = SaleDss::where('question_2', 'LIKE', '%Quality%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $customer_service = SaleDss::where('question_2', 'LIKE', '%CustomerService%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $happy_with_dss = SaleDss::where('question_2', 'LIKE', '%HappywithDss%')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $others_question_2 = SaleDss::select('others_question_2')
                ->where('others_question_2', '!=', 'NULL')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
            $amazon_count = count($amazon);
            $becker_count = count($beckers);
            $lackshore_count = count($lackshore);
            $kaplan_count = count($kaplan);
            $discount_school_supply_count = count($discount_school_supply);
            $oriental_trading_count = count($oriental_trading);
            $use_multiple_vendor_count = count($use_multiple_vendor);
            $others_question_1_count = count($others_question_1);
            $question_4_count = count($question_4);
            $question_3_count = count($question_3);
            $question_3_1_1_count = count($question_3_1_1); 
            $question_4_1_count = count($question_4_1);
            $question_3_1_count = count($question_3_1);
            $question_3_1_7_count = count($question_3_1_7);
            $question_3_2_1_count = count($question_3_2_1);
            $question_3_2_2_count = count($question_3_2_2);
            $question_3_2_3_count = count($question_3_2_3);
            $question_3_2_4_count = count($question_3_2_4);
            $question_3_2_5_count = count($question_3_2_5);
            $question_3_2_6_count = count($question_3_2_6);

            
            $pricing_count = count($pricing);
            $lack_of_products_count = count($lack_of_products);
            $fast_shipping_count = count($fast_shipping);
            $free_shipping_count = count($free_shipping);
            $quality_count = count($quality);
            $school_speciality_count = count($school_speciality);
            $customer_service_count = count($customer_service);
            $happy_with_dss_count = count($happy_with_dss);
            $others_question_2_count = count($others_question_2);
            return view('admin.dss.product-chart', compact('amazon_count', 'becker_count', 
            'lackshore_count', 'kaplan_count', 'discount_school_supply_count',
             'school_speciality_count', 'oriental_trading_count', 'use_multiple_vendor_count', 'pricing_count', 'lack_of_products_count', 
             'free_shipping_count', 'fast_shipping_count', 'quality_count', 'school_speciality_count', 'customer_service_count', 
             'happy_with_dss_count', 'others_question_2_count','others_question_1_count', 'question_4_count',
             'question_4_1_count', 'question_3_1_count','question_3_count','question_3_1_1_count','question_3_2_1_count','question_3_2_1_count'
             ,'question_3_2_2_count'
             ,'question_3_2_3_count'
             ,'question_3_2_4_count'
             ,'question_3_2_5_count'
             ,'question_3_2_6_count'
            ,'question_3_1_7_count'));
        }

        $amazon = SaleDss::where('question_1', 'LIKE', '%Amazon%')->get();
        $beckers = SaleDss::where('question_1', 'LIKE', '%Beckers%')->get();
        $lackshore = SaleDss::where('question_1', 'LIKE', '%Lackshore%')->get();
        $kaplan = SaleDss::where('question_1', 'LIKE', '%Kaplan%')->get();
        $discount_school_supply = SaleDss::where('question_1', 'LIKE', '%Discountschoolsupply%')->get();
        $school_speciality = SaleDss::where('question_1', 'LIKE', '%Schoolspeciality%')->get();
        $oriental_trading = SaleDss::where('question_1', 'LIKE', '%OrientalTrading%')->get();
        $use_multiple_vendor = SaleDss::where('question_1', 'LIKE', '%UsemultipleVendor%')->get();
        $others_question_1 = SaleDss::select('others_question_1')->where('others_question_1', '!=', 'NULL')->get();

        $question_4 = SaleDss::where('question_4', 'LIKE', '%Yes%')->get();
        $question_4_1 = SaleDss::where('question_4', 'LIKE', '%No%')->get();

        $question_3 = SaleDss::where('question_3', 'LIKE', '%Yes%')->get();
        $question_3_1_1 = SaleDss::where('question_3', 'LIKE', '%No%')->get();

        $question_3_1 = SaleDss::where('question_3_1', 'LIKE', '%REFURBISHING%')->get();
        $question_3_1_7 = SaleDss::where('question_3_1', 'LIKE', '%NEW ADDITION%')->get();
        $question_3_2_1 = SaleDss::where('question_3_2', 'LIKE', '%1-3 months%')->get();
        $question_3_2_2 = SaleDss::where('question_3_2', 'LIKE', '%3-6 months%')->get();
        $question_3_2_3 = SaleDss::where('question_3_2', 'LIKE', '%6-9 months%')->get();
        $question_3_2_4 = SaleDss::where('question_3_2', 'LIKE', '%A year%')->get();
        $question_3_2_5 = SaleDss::where('question_3_2', 'LIKE', '%Not Yet Defined%')->get();
        $question_3_2_6 = SaleDss::where('question_3_2', 'LIKE', '%No info%')->get();

        $pricing = SaleDss::where('question_2', 'LIKE', '%Pricing%')->get();
        $lack_of_products = SaleDss::where('question_2', 'LIKE', '%Lackofproducts%')->get();
        $fast_shipping = SaleDss::where('question_2', 'LIKE', '%FastShipping%')->get();
        $free_shipping = SaleDss::where('question_2', 'LIKE', '%FreeShipping%')->get();
        $quality = SaleDss::where('question_2', 'LIKE', '%Quality%')->get();
        $customer_service = SaleDss::where('question_2', 'LIKE', '%CustomerService%')->get();
        $happy_with_dss = SaleDss::where('question_2', 'LIKE', '%HappywithDss%')->get();
        $others_question_2 = SaleDss::select('others_question_2')
            ->where('others_question_2', '!=', 'NULL')
            ->get();
        $amazon_count = count($amazon);
        $becker_count = count($beckers);
        $lackshore_count = count($lackshore);
        $kaplan_count = count($kaplan);
        $discount_school_supply_count = count($discount_school_supply);
        $oriental_trading_count = count($oriental_trading);
        $use_multiple_vendor_count = count($use_multiple_vendor);
        $others_question_1_count = count($others_question_1);
        $question_4_count = count($question_4);
        $question_4_1_count = count($question_4_1);
        $question_3_1_count = count($question_3_1);
        $question_3_1_7_count = count($question_3_1_7);
        $question_3_2_1_count = count($question_3_2_1);
        $question_3_2_2_count = count($question_3_2_2);
        $question_3_2_3_count = count($question_3_2_3);
        $question_3_2_4_count = count($question_3_2_4);
        $question_3_2_5_count = count($question_3_2_5);
        $question_3_2_6_count = count($question_3_2_6);
        $question_3_count = count($question_3);
        $question_3_1_1_count = count($question_3_1_1); 
        $pricing_count = count($pricing);
        $lack_of_products_count = count($lack_of_products);
        $fast_shipping_count = count($fast_shipping);
        $free_shipping_count = count($free_shipping);
        $quality_count = count($quality);
        $school_speciality_count = count($school_speciality);
        $customer_service_count = count($customer_service);
        $happy_with_dss_count = count($happy_with_dss);
        $others_question_2_count = count($others_question_2);

        return view('admin.dss.product-chart', compact('amazon_count', 'becker_count', 'lackshore_count',
         'kaplan_count', 'discount_school_supply_count', 'school_speciality_count', 'oriental_trading_count',
          'use_multiple_vendor_count', 'pricing_count', 'lack_of_products_count', 'free_shipping_count', 
          'fast_shipping_count', 'quality_count', 'school_speciality_count', 'customer_service_count',
           'happy_with_dss_count', 'others_question_2_count', 'others_question_1_count', 'question_4_count',
            'question_4_1_count', 'question_3_1_count',
            'question_3_count','question_3_1_1_count','question_3_2_1_count','question_3_2_2_count' ,'question_3_2_3_count'
 ,'question_3_2_4_count'
            ,'question_3_2_5_count'
            ,'question_3_2_6_count'
            ,'question_3_1_7_count'));
    }
    public function exportDSSSalesReport(Request $request)
    {
        $now = now();
        return Excel::download(new DSSExport($request), "DSS-Sales-Report-{$now->toString()}.xlsx");
    }
}
