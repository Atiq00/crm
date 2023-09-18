<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EddyExport;
use App\Imports\EddyImport;
use App\Models\EddySale;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

 
class EddyController extends Controller
{
    public function importForm(Request $request)
    {
        // return $request; 
        $eddy = new EddySale(); 
        $eddy  = $eddy->select('*');
        if ($request->agent_id)
            $eddy = $eddy->where('agent_id', $request->agent_id);
        if ($request->f_date)
            $eddy = $eddy->whereDate('sale_date',">=", $request->f_date);
        if ($request->t_date)
            $eddy = $eddy->whereDate('sale_date',"<=", $request->t_date);
        if ($request->type){
            
            if($request->type == "Inbound"){
                $eddy = $eddy->where(function($query){
                    $eddy = $query->where('agent_id', "LIKE BINARY","%ts_%"); 
                }); 
            }                
            if($request->type == "Outbound"){ 
                $eddy = $eddy->where(function($query){
                    $eddy = $query->where('agent_id', "LIKE BINARY","%TS_OB%"); 
                }); 
            }
                
            if($request->type == "EddyEdu"){
               
                $eddy = $eddy->where(function($query){
                    $eddy = $query->where('agent_id', "LIKE BINARY","%TS_IA%"); 
                }); 
            }
			
			if($request->type == "EducationFirst"){
               
                $eddy = $eddy->where(function($query){
                    $eddy = $query->where('agent_id', "LIKE BINARY","%EF_OB%"); 
                }); 
            }
                
        }            
        $eddy = $eddy->with('user')->orderBy('id', "DESC")->Paginate(50);


        $sum = new EddySale(); 
        $sum  = $sum->select('*');
        if ($request->agent_id)
            $sum = $sum->where('agent_id', $request->agent_id);
        if ($request->f_date)
            $sum = $sum->whereDate('sale_date',">=", $request->f_date);
        if ($request->t_date)
            $sum = $sum->whereDate('sale_date',"<=", $request->t_date);
        if ($request->type){            
            if($request->type == "Inbound"){
                $sum = $sum->where(function($query){
                    $sum = $query->where('agent_id', "LIKE BINARY","%ts_%"); 
                }); 
            }                
            if($request->type == "Outbound"){ 
                $sum = $sum->where(function($query){
                    $sum = $query->where('agent_id', "LIKE BINARY","%TS_OB%"); 
                }); 
            }                
            if($request->type == "EddyEdu"){               
                $sum = $sum->where(function($query){
                    $sum = $query->where('agent_id', "LIKE BINARY","%TS_IA%"); 
                }); 
            }
			if($request->type == "EducationFirst"){
               
                $sum = $sum->where(function($query){
                    $sum = $query->where('agent_id', "LIKE BINARY","%EF_OB%"); 
                }); 
            }
        }
        $sum = $sum->selectRaw("sum(billable_hours) AS Quantity")->first();         
        $hours = @$sum->Quantity;

        
        
        
        return view('admin.eddy-sales.import-form', compact('eddy','hours'));
    }
    public function import(Request $request)
    {
        // return $request->type;
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new EddyImport(), request()->file('file'), $request->type);
        Session::flash('success', 'File Uploaded successfully!');
        return back();
    }
    public function exportEddyReport(Request $request)
    {
        $now = now();
        return Excel::download(new EddyExport($request), "Eddy-Sales-Report-{$now->toString()}.xlsx");
    }
    public function eddyusers(){
        $users = DB::table('eddy_users')->where('status',1)->get();
        return view('admin.eddy-sales.index', compact('users'));
    }
    public function eddyuserCreate(Request $request){ 
        
        $project_code='';
        if($request->submit){
            if($request->type == "InBound"){
                $project_code ="PRO0146";
            }elseif($request->type == "OutBound"){
                $project_code ="PRO0147";
            }
            elseif($request->type == "EddyEdu"){
                $project_code ="PRO0145";
            }
            
            DB::table('eddy_users')->insert([
                'name' =>$request->name,
                'psedo_name' =>$request->psedo_name,
                'agent_name' =>$request->agent_name,
                'HRMSID' =>$request->HRMSID,
                'type' =>$request->type,
                'project_code' =>$project_code,
            ]);

            return redirect('admin/eddyusers')->with('success',"User Create Successfully");
        }
        return view('admin.eddy-sales.create');
    }

    public function eddyuserDelete(Request $request , $id) {
        DB::table('eddy_users')->where('id',$id)->update(['status' => 0]);
        return redirect('admin/eddyusers')->with('success',"User Delete Successfully");
    }
    public function eddySaleDelete(Request $request) {
        // return $request;
        // EddySale::whereDate('sale_date',$request->date)->where('type',$request->type)->delete();
        // return redirect()->back()->with('success',"User Delete Successfully");
    }
}
