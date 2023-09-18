<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KbCategory;
use Illuminate\Http\Request;
use App\Http\Requests\KbCategoryRequest;

class KbCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.kb_category')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('kb_category.index');
        $kb_categories  =   KbCategory::all();
        return view('admin.kb_category.index', compact('kb_categories'));
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
    public function store(KbCategoryRequest $request)
    {
        $this->authorize('kb_category.create');

        $data = $request->except(['img', 'img_type', 'img_url']);
        $data['img']  = "";

        if($request->get('img_type')=='.img-url'){
            $data['img'] = $request->get('img_url');
        }

        $kb_category = KbCategory::create( $data );

        if($request->hasFile('img') && $request->get('img_type')=='.img-file')
        {

            $allowedfileExtension=['jpg','png', 'gif', 'jpeg', 'svg'];
            $file = $request->file('img');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenames = $file->store('kb_icons', 'uploads');
            $kb_category->img = '{site_url}/uploads/'.$filenames;

            $kb_category->update();

        }
        
        return redirect()->route('kb_categories.index')->with('success', __('messages.kb_category_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KbCategory  $KbCategory
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
     * @param  \App\Models\KbCategory  $KbCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('kb_category.edit');
        $kb_categories  =   KbCategory::all();
        $category = KbCategory::find($id);
        return view('admin.kb_category.edit', compact('category', 'kb_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KbCategory  $KbCategory
     * @return \Illuminate\Http\Response
     */
    public function update(KbCategoryRequest $request, $id)
    {
        $this->authorize('kb_category.edit');

        $data = $request->except(['img', 'img_type', 'img_url']);

        if($request->get('img_type')=='.img-url'){
            $data['img'] = $request->get('img_url');
        }

        if($request->hasFile('img') && $request->get('img_type')=='.img-file')
        {

            $allowedfileExtension=['jpg','png', 'gif', 'jpeg', 'svg'];
            $file = $request->file('img');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenames = $file->store('kb_icons', 'uploads');
            $data['img'] = '{site_url}/uploads/'.$filenames;
        }

        KbCategory::find($id)->update($data);

        return redirect()->route('kb_categories.index')->with('success', __('messages.kb_category_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KbCategory  $KbCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('kb_category.delete');
        KbCategory::find($id)->delete();
        return redirect()->route('kb_categories.index')->with('success', __('messages.kb_category_deleted'));
    }
}
