<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeBase;
use App\Models\KbSubCategory;
use App\Models\KbCategory;
use Illuminate\Http\Request;
use App\Http\Requests\KnowledgeBaseRequest;

class KnowledgeBaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.knowledge_bases')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('kb.index');
        $knowledge_bases  =   KnowledgeBase::select('*');

        $request_category = $request->has('category') && $request->get('category')!='all' && !empty($request->get('category')) ? explode('_', $request->get('category')) : [0, 0] ;
        $category = (int) $request_category[0] > 0 ? $request_category[0] : false;
        $sub_category = (int) isset($request_category[1]) && $request_category[1] > 0 ? $request_category[1] : false;
        
        if( $category && $category = KbCategory::findOrFail($category) ){
            $knowledge_bases->where('category_id', (int) $category->id);
        }
        if( $sub_category && $sub_category = KbSubCategory::findOrFail($sub_category) ){
            $knowledge_bases->where('sub_category_id', (int) $sub_category->id);
        }

        $knowledge_bases  = $knowledge_bases->get();

        $kb_categories  =   KbCategory::all();

        // $knowledge_bases  =   KnowledgeBase::all();
        return view('admin.knowledge_base.index', compact('knowledge_bases', 'kb_categories', 'category', 'sub_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('kb.create');
        $kb_categories  =   KbCategory::all();
        return view('admin.knowledge_base.create', compact('kb_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeBaseRequest $request)
    {
        $this->authorize('kb.create');

        $data = $request->except(['sub_category_id']);

        $request_category = explode('_', $request->get('sub_category_id'));

        $data['category_id']    =   $request_category[0];
        $data['sub_category_id']    = isset($request_category[1]) ?  $request_category[1] : null;

        $kb = KnowledgeBase::create($data);
        return redirect()->route('knowledge_bases.index')->with('success',  __('messages.knowledge_base_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('kb.index');
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
        $this->authorize('kb.edit');
        $kb_categories  =   KbCategory::all();
        $kb  =   KnowledgeBase::find($id);
        return view('admin.knowledge_base.edit', compact('kb_categories', 'kb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeBaseRequest $request, $id)
    {
        $this->authorize('kb.edit');
        $data = $request->except(['sub_category_id']);

        $request_category = explode('_', $request->get('sub_category_id'));

        $data['category_id']    =   $request_category[0];
        $data['sub_category_id']    = isset($request_category[1]) ?  $request_category[1] : null;

        KnowledgeBase::find($id)->update( $data );
        return redirect()->route('knowledge_bases.index')->with('success',  __('messages.knowledge_base_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('kb.delete');
        KnowledgeBase::find($id)->delete($id);
        return redirect()->route('knowledge_bases.index')->with('success',  __('messages.knowledge_base_deleted'));
    }
}
