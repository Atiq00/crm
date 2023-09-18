<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CovidSales;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CovidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        view()->share(
            'site',
            (object) [
                'title' => 'Covid-Kit',
            ],
        );
    }
    public function index(Request $request)
    {
        //
        $query = new CovidSales();

        if ($request->has('start_date') || $request->has('end_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            } elseif (!empty($request->start_end)) {
                $query = $query->whereDate('created_at', $request->start_end);
            }
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
        } else {
            $query = $query->whereDate('created_at', '=', date('Y-m-d'));
        }
        $covid = $query->with('project', 'client')
            ->latest()
            ->paginate(100);

        return view('admin.covid.index', compact('covid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.covid.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $orgDate = $request->dob;  
        // $newDate = date("m-d-Y", strtotime($orgDate));  
        // $data = $request->all();
        // $data['provider'] = '281';
        // $data['first_name'] = $request->first_name;
        // $data['last_name'] = $request->last_name;
        // $data['phone'] = $request->phone;
        // $data['medi_num '] = $request->medi_num;
        // $data['dob'] =  $newDate; 

        CovidSales::create($request->all());

        // $lastrecord = CovidSales::latest('id')->first();

        // $queryString = http_build_query($data);
        // $url = 'https://arlo.tycoonmach.net/api/medi-leads?' . $queryString; //url of 2nd website where data is to be send
        // $postdata = $data;
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type', 'application/json']);
        // $result = curl_exec($ch);
        // //echo $result;
        // curl_close($ch);

        // DB::table('covid_kit')
        //     ->where('id', $lastrecord->id)
        //     ->update([
        //         'post_data' => $data,
        //         'post_response' => $result,
        //     ]);
        Session::flash('success', 'Record Added Successfylly!');
        
        return redirect()->route('covid.create');

    
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
