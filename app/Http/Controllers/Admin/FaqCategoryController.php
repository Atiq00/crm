<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FaqCategory;

class FaqCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>   __('labels.faq_category')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('faq_category.index');
        $faq_categories  =   FaqCategory::all();
        return view('admin.faq_category.index', compact('faq_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('faq_category.create');
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
        $this->authorize('faq_category.create');

        $request->validate([
            'name' => 'required|unique:faq_categories|max:255',
        ]);

        $user = FaqCategory::create( $request->only(['name']) );
        return redirect()->route('faq-category.index')->with('success',  __('messages.faq_category_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('faq_category.index');
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
        $this->authorize('faq_category.edit');
        $category   =   FaqCategory::find($id);
        return view('admin.faq_category.edit', compact('category'));
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
        $this->authorize('faq_category.edit');

        $request->validate([
            "name" => "required|unique:faq_categories,$id|max:255",
        ]);

        
        FaqCategory::find($id)->update($request->only(['name']));

        return redirect()->route('faq-category.index')->with('success',  __('messages.faq_category_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('faq_category.delete');
        FaqCategory::find($id)->delete();
        return redirect()->route('faq-category.index')->with('success', __('messages.faq_category_deleted'));
    }
}
