<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\KnowledgeBase;
use App\Models\KbCategory;
use App\Models\KbSubCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Main Page - Home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kb_categories = KbCategory::orderBy('name', 'asc')->get()->only( json_decode(setting('home_featured_categories')) );
        $faq_categories = FaqCategory::get();
        $popular_articles = KnowledgeBase::limit( setting('home_max_articles') )->get();
        $recent_articles = KnowledgeBase::limit( setting('home_max_articles') )->latest()->get();
        $helpful_articles = KnowledgeBase::limit( setting('home_max_articles') )->orderBy('helpful_yes', 'desc')->get();
        return view('frontend.home', compact('kb_categories', 'popular_articles', 'recent_articles', 'helpful_articles'));
    }

    /**
     * FAQ PAge
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        $faq_categories = FaqCategory::get();
        // $faq_categories = [];
        return view('frontend.faq', compact('faq_categories'));
    }

    // /**
    //  * Knowledge Base PAge
    //  *
    //  * @return \Illuminate\View\View
    //  */
    // public function KnowledgeBases()
    // {
    //     $kb_categories = KbCategory::orderBy('name', 'asc')->get();

    //     // $kb_categories = [];
    //     return view('frontend.knowledge_bases.index', compact('kb_categories'));
    // }

    /**
     * Knowledge Base PAge
     *
     * @return \Illuminate\View\View
     */
    public function KnowledgeBasesCategoryDetail($id)
    {
        $kb_category = KbCategory::findOrFail($id);

        // $kb_categories = [];
        return view('frontend.knowledge_bases.category-page', compact('kb_category'));
    }

    /**
     * Knowledge Base PAge
     *
     * @return \Illuminate\View\View
     */
    public function KbArticleDetail($id)
    {
        $knowledge_base = KnowledgeBase::findOrFail($id);
        
        $related_articles = KnowledgeBase::where('category_id', $knowledge_base->category_id)->where('id', '!=', $knowledge_base->id)->get(); 
        
        $related_categories = KbSubCategory::where('category_id', $knowledge_base->category->id)->where('id', $knowledge_base->sub_category_id)->where('id', '!=', @$knowledge_base->sub_category_id->id)->get();
        
        return view('frontend.knowledge_bases.article-detail', compact('knowledge_base', 'related_articles', 'related_categories'));
    }

    /**
     * Knowledge Base PAge
     *
     * @return \Illuminate\View\View
     */
    public function KbArticleUpdateHelpfull(Request $request, $id)
    {

        $request->validate([
            'update' => 'required|in:yes,no',
        ]);

        $knowledge_base = KnowledgeBase::where('id', $id);

        $knowledge_base->update([ 'helpful_'.$request->update =>  \DB::raw( 'helpful_'.$request->update.'+1') ]);

        $knowledge_base = $knowledge_base->get()->first();

        return response()->json([
            'status'    =>  true,
            'yes'       =>  $knowledge_base->helpful_yes,
            'no'       =>  $knowledge_base->helpful_no,
        ]);
    }


    /**
     * Knowledge Base PAge
     *
     * @return \Illuminate\View\View
     */
    public function KnowledgeBaseSubCategory(Request $request, $category_slug, $sub_category_id)
    {
        $kb_sub_category = KbSubCategory::findOrFail($sub_category_id);
        $kb_category = $kb_sub_category->category;
        $kb_articles = KnowledgeBase::where('sub_category_id', $kb_sub_category->id);

        // $kb_categories = [];
        return view('frontend.knowledge_bases.sub-category-page', compact('kb_category', 'kb_sub_category', 'kb_articles'));
    }


    /**
     * Knowledge Base PAge
     *
     * @return \Illuminate\View\View
     */
    public function searchResults (Request $request)
    {

        $searched_terms = [ 
            'query' => '',
            'category_id' => '',
            'sub_category_id' => '',
        ];

        $searched_terms['query'] = $request->get('query') ?? '';
        
        $kb_articles = KnowledgeBase::where('title', 'like', '%'.$searched_terms['query'].'%');

        $kb_articles->orWhere('description', 'like', '%'.$searched_terms['query'].'%');

        if( $request->has('category_id') && @$request->category_id!='all' ){
            
            $request_category = explode('_', request()->category_id);
            $category = $request_category[0];
            $sub_category = isset($request_category[1]) ? $request_category[1] : 0 ;

            $kb_articles->where( 'category_id', $category );
            $searched_terms['category_id'] = $category;

            if(!empty($sub_category)){
                $kb_articles->where( 'sub_category_id', $sub_category );
                $searched_terms['sub_category_id'] = $sub_category;

            }
        }
        
        $kb_categories = KbCategory::all();
        

        return view('frontend.knowledge_bases.search-results', compact('kb_articles', 'searched_terms', 'kb_categories'));
    }

    public function AllCategories()
    {
        $kb_categories = KbCategory::orderBy('name', 'asc')->get();
        return view('frontend.knowledge_bases.all-categories', compact('kb_categories'));
    }
    
    public function setLanguage($locale)
    {
        \App::setlocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

}
