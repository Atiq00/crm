<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KbCategory;
use App\Models\KbSubCategory;
use Illuminate\Http\Request;

class KbSubCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.kb_sub_category')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('kb_category.index');
        $kb_sub_categories  =   KbSubCategory::select('*');
        
        if($request->has('category') && !empty($request->get('category')) && $request->get('category')!='all' && $category = KbCategory::findOrFail($request->get('category')) )
            $kb_sub_categories->where('category_id', (int) $request->get('category'));

        $kb_sub_categories  = $kb_sub_categories->get();

        $kb_categories  =   KbCategory::all();
        return view('admin.kb_sub_category.index', compact('kb_categories', 'kb_sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('kb_category.create');
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
        $this->authorize('kb_category.create');

        KbSubCategory::create( $request->all() );
        return redirect()->route('kb_sub_categories.index')->with('success',__('messages.kb_sub_category_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KbSubCategory  $KbSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(KbCategory $KbCategory)
    {
        $this->authorize('kb_category.index');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KbSubCategory  $KbSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('kb_category.edit');
        $kb_categories  =   KbCategory::all();
        $category = KbSubCategory::find($id);
        return view('admin.kb_sub_category.edit', compact('category', 'kb_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KbSubCategory  $KbSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('kb_category.edit');
        
        KbSubCategory::find($id)->update($request->all());

        return redirect()->route('kb_sub_categories.index')->with('success', __('messages.kb_sub_category_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KbSubCategory  $KbSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('kb_category.delete');
        KbSubCategory::find($id)->delete();
        return redirect()->route('kb_sub_categories.index')->with('success', __('messages.kb_sub_category_deleted'));
    }

    /**
     * Returns SubCategories according to its parent. Returns JSON
     *
     * @param  \App\Models\KbSubCategory  $KbSubCategory
     * @return \Illuminate\Http\Response
     */
    public function ajaxData($parent)
    {
        $kb_sub_categories = KbSubCategory::where('category_id', (int) $parent)->get();

        return $kb_sub_categories;

    }
}
