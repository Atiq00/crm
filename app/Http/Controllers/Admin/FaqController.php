<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\FaqRequest;

use App\Models\FaqCategory;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.faq')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('faq.index');
        $faqs  =   Faq::all();
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('faq.create');
        $faq_categories  =   FaqCategory::all();
        return view('admin.faq.create', compact('faq_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        $this->authorize('faq.create');
        $faq = Faq::create($request->all());
        return redirect()->route('faqs.index')->with('success', __('messages.faq_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('faq.index');
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
        $this->authorize('faq.edit');
        $faq_categories  =   FaqCategory::all();
        $faq  =   Faq::find($id);
        return view('admin.faq.edit', compact('faq_categories', 'faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $this->authorize('faq.edit');
        $faq->update( $request->all() );
        return redirect()->route('faqs.index')->with('success', __('messages.faq_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $this->authorize('faq.delete');
        $faq->delete();
        return redirect()->route('faqs.index')->with('success', __('messages.faq_deleted'));
    }
}
