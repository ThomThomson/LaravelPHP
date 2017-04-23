<?php

namespace App\Http\Controllers;

use App\Article;
use App\ContentArea;
use App\ArticleModification;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class articleController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'checkEditArticleAccess']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $articles = Article::all();
        return view('management.viewArticles', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $contentAreas = ContentArea::all();
        $pages = Page::all();
        return view('management.editArticle', compact('contentAreas', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //Validate the Request
        $this->validate($request, [
            'articleName' => 'required',
            'articleTitle' => 'required',
            'articleHtml' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('articleName');
        $title = $request->input('articleTitle');
        $description = $request->input('articleDescription');
        $htmlContent = $request->input('articleHtml');

        $allPages = false;

        $page = $request->input('articlePage');
        $contentArea = $request->input('articleContentArea');

        if($page == 'NO_SELECTION'){$page = null;}
        else if($page == 'ALL_PAGES'){$page = null; $allPages = true;}
        if($contentArea == 'NO_SELECTION'){$contentArea = null;}

        //Create a new Article with that input
        Article::create(['name' => $name, 'title' => $title, 'description' => $description,
            'page' => $page, 'allPages' => $allPages, 'contentArea' => $contentArea, 'htmlContent' => $htmlContent,
            'createdBy' => Auth::id()]);
        return redirect('manage/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $article = Article::find($id);
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $contentAreas = ContentArea::all();
        $pages = Page::all();
        $article = Article::find($id);
        $modificationList = ArticleModification::with('User')->where('articleModified', $id)->orderBy('created_at', 'desc')->get();
        $createdBy = User::find($article->createdBy);
        return view('management.editArticle', compact('article', 'pages', 'contentAreas', 'modificationList', 'createdBy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //Validate the Request
        $this->validate($request, [
            'articleName' => 'required',
            'articleTitle' => 'required',
            'articleHtml' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('articleName');
        $title = $request->input('articleTitle');
        $description = $request->input('articleDescription');
        $allPages = false;

        $page = $request->input('articlePage');
        $contentArea = $request->input('articleContentArea');

        if($page == 'NO_SELECTION'){$page = null;}
        else if($page == 'ALL_PAGES'){$page = null; $allPages = true;}
        if($contentArea == 'NO_SELECTION'){$contentArea = null;}

        $htmlContent = $request->input('articleHtml');
        //Get the Article that the request will edit
        $currentArticle = Article::find($id);
        //replace all the params inside the Article.
        $currentArticle->name = $name; $currentArticle->title = $title; $currentArticle->allPages = $allPages;
        $currentArticle->description = $description; $currentArticle->page = $page;
        $currentArticle->contentArea = $contentArea; $currentArticle->htmlContent = $htmlContent;
        //save that Article
        $currentArticle->save();
        //make a new modification record
        ArticleModification::create(['modifiedBy' => Auth::user()->id, 'articleModified' => $id]);
        //and finally redirect back to Index
        if(Auth::user()->getIsAuthorAttribute() && !Auth::user()->getIsEditorAttribute()){
            return redirect('/');
        }else{
            return redirect('manage/articles');   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $currentArticle = Article::find($id);

        $modifications = ArticleModification::where('articleModified', $currentArticle->id)->get();
        foreach($modifications as $modification){
            $modification->delete();
        }
        $currentArticle->delete();

        return redirect('manage/articles');
    }
}
