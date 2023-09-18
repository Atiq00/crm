<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CallAnalyticImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\CallAnalyticSale;

class CallAnalyticController extends Controller
{
    public function importForm()
    {
        $sales = CallAnalyticSale::with('user','project')->paginate(100);
        return view('admin.call-analytic-sales.import-form',compact('sales'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new CallAnalyticImport(), request()->file('file'));
        Session::flash('success', 'File Uploaded successfully!');
        return back();
    }
    public function delete($id)
    {        
        $this->authorize('campaign.delete');
        CallAnalyticSale::where('id',$id)->delete(); 
        return redirect()->back()->with('success', "Delete Successfully");
    }
    public function stats(Request $request)
    {
       // dd($request);
        $start_date = @$request->start_date;
        $end_date = @$request->end_date;
        $start_date_ach = @$request->start_date_ach;
        $end_date_ach = @$request->end_date_ach;
        $start_date_ach_goal = @$request->start_date_ach_goal;
        $end_date_ach_goal = @$request->end_date_ach_goal;
        $start_date_ach_goal_month = @$request->start_date_ach_goal_month;
        $end_date_ach_goal_month = @$request->end_date_ach_goal_month;

        $dailycount = new CallAnalyticSale;
        $per = 0;
        $per_month = 0;
        $dailycount1=0;
        $dailycount2=0;

        if($request->start_date && $request->end_date){
            $dailycount = $dailycount->whereDate('sale_date',">=",$request->start_date)->whereDate('sale_date',"<=",$request->end_date)->sum('count');
        }
        if ($request->start_date_ach && $request->end_date_ach)
        {
            $dailycount1 = new CallAnalyticSale;
            $dailycount1 = $dailycount1->whereDate('sale_date',">=",$request->start_date_ach)->whereDate('sale_date',"<=",$request->end_date_ach)->sum('count');

        }


       if ($request->start_date_ach_goal && $request->end_date_ach_goal)
        {
            $wl = CallAnalyticSale::whereDate('sale_date',">=",$request->start_date_ach_goal)->whereDate('sale_date',"<=",$request->end_date_ach_goal)->sum('count');
            $total=6300;
            $per = $wl/$total * 100;

         // $dailycount2 = $dailycount2->whereDate('sale_date',">=",$request->start_date_ach_goal)->whereDate('sale_date',"<=",$request->end_date_ach_goal)->sum('count');
         }
         if ($request->start_date_ach_month && $request->end_date_ach_month)
         {
             $dailycount2 = new CallAnalyticSale;
             $dailycount2 = $dailycount2->whereDate('sale_date',">=",$request->start_date_ach_month)->whereDate('sale_date',"<=",$request->end_date_ach_month)->sum('count');

         }
         if ($request->start_date_ach_goal_month && $request->end_date_ach_goal_month)
         {
             $wl = CallAnalyticSale::whereDate('sale_date',">=",$request->start_date_ach_goal_month)->whereDate('sale_date',"<=",$request->end_date_ach_goal_month)->sum('count');
             $total=126000;
             $per_month = $wl/$total * 100;

          // $dailycount2 = $dailycount2->whereDate('sale_date',">=",$request->start_date_ach_goal)->whereDate('sale_date',"<=",$request->end_date_ach_goal)->sum('count');
          }

        return view('admin.call-analytic-sales.cax-stats',compact('dailycount','dailycount1','per' ,'dailycount2' , 'per_month' ));
    }
}
