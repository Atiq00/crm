<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\ProjectCode;


class ProjectCodeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageProject()
    {
        $projects = ProjectCode::where('parent_id', '=', 0)->get();
        $allProjects = ProjectCode::pluck('title','id')->all();
        return view('projectTreeview',compact('projects','allProjects'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addProject(Request $request)
    {
        $this->validate($request, [
        		'title' => 'required',
        	]);
        $projectCount = ProjectCode::where('title', $request->title)->orWhere('code', $request->code)->count();

        if($projectCount > 0){
            return back()->with('error', 'Duplicate entry.');
        }    
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        
        ProjectCode::create($input);
        return back()->with('success', 'New Project added successfully.');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProject(Request $request)
    {
        $this->validate($request, [
        		'title' => 'required',
        	]);
        $input = $request->all();
        //print_r($input);exit;
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        
        ProjectCode::where('id',$request->id)->update([
            'title'=>$request->title,
            'code'=>$request->code,
            'parent_id'=>$request->parent_id,
        ]);
        return back()->with('success', 'Project updated successfully.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteProject($id)
    {
        $user = ProjectCode::find($id);
        $user->delete();
        // ProjectCode::where('id',$request->id)->delete();
        return back()->with('success', 'Project deleted.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProject($code)
    {

        $result = ProjectCode::select(['id','parent_id','code','title'])->where('code','=', trim($code))->first();

        $response = [
            'success' => true,
            'status'  => 200,
            'code'    => 'success',
            'data'    => $result,
        ];

        return response()->json($response, 200);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChildProjects($id)
    {
        $result = ProjectCode::where('parent_id', '=', $id)->get();

        $response = [
            'success' => true,
            'status'  => 200,
            'code'    => 'success',
            'data'    => $result,
        ];

        return response()->json($response, 200);

    }    

}