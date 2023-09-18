<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CMUSaleImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\CMUSale;

class CMUSaleController extends Controller
{
    public function importForm(Request $request)
    {
        $sales = \DB::table('cmu_sales')->select('cmu_sales.*','latest_users.name','projects.project_code','projects.name as project_name')
                ->leftjoin('latest_users','latest_users.HRMSID',"=","cmu_sales.hrms_id")
                ->leftjoin('projects','projects.project_code',"=","cmu_sales.project_code");
        if($request->hrms_id){
            $sales = $sales->where('cmu_sales.hrms_id',$request->hrms_id);
        }if($request->project_code){
            $sales = $sales->where('cmu_sales.project_code',$request->project_code);
        }
        if($request->fromdate){
            $sales = $sales->whereDate('cmu_sales.sale_date',">=",$request->fromdate);
        }if($request->todate){
            $sales = $sales->whereDate('cmu_sales.sale_date',"<=",$request->todate);
        }
        $sales = $sales->whereNull('cmu_sales.deleted_at');
        
        $sales = $sales ->paginate(50);
        $projects = \DB::table('projects')->where('client_id',28)->get();  
        
        


        $projectbase = \DB::table('cmu_sales')->selectRaw(" 
            projects.name as Project,
            projects.abbrivation as abbrivation,
            SUM(cmu_sales.count) AS Quantity              
        ")
        ->leftjoin('latest_users','latest_users.HRMSID',"=","cmu_sales.hrms_id")
        ->leftjoin('projects','projects.project_code',"=","cmu_sales.project_code");
        if($request->hrms_id){
            $projectbase = $projectbase->where('cmu_sales.hrms_id',$request->hrms_id);
        }if($request->project_code){
            $projectbase = $projectbase->where('cmu_sales.project_code',$request->project_code);
        }
        if($request->fromdate){
            $projectbase = $projectbase->whereDate('cmu_sales.sale_date',">=",$request->fromdate);
        }if($request->todate){
            $projectbase = $projectbase->whereDate('cmu_sales.sale_date',"<=",$request->todate);
        }
        $projectbase = $projectbase->whereNull('cmu_sales.deleted_at');
        $projectbase = $projectbase->groupBy('cmu_sales.project_code')->get();

        return view('admin.cmu-sales.import-form',compact('sales','projects','projectbase'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new CMUSaleImport(), request()->file('file'));
        Session::flash('success', 'File Uploaded successfully!');
        return back();
    }
    public function delete(Request $request)
    {        
        $this->authorize('campaign.delete');
        CMUSale::where('id',$request->id)->delete(); 
        return redirect()->back()->with('success', "Delete Successfully");
    }
}
