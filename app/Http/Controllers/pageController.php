<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageModification;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

use App\Http\Requests;

class pageController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'checkEditor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $pages = Page::all();
        return view('management.viewPages', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('management.editPage');
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
            'pageName' => 'required',
            'pageAlias' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('pageName');
        $alias = $request->input('pageAlias');
        $description = $request->input('pageDescription');
        //Create a new Content Area with that input
        Page::create(['name' => $name, 'alias' => $alias, 'description' => $description,
            'createdBy' => Auth::id()]);
        return redirect('/manage/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $page = Page::find($id);
        return $page;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $page = Page::find($id);
        $createdBy = User::find($page->createdBy);
        $modificationList = PageModification::with('User')->where('pageModified', $id)->orderBy('created_at', 'desc')->get();
        return view('management.editPage', compact('page', 'createdBy', 'modificationList'));
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
            'pageName' => 'required',
            'pageAlias' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('pageName');
        $alias = $request->input('pageAlias');
        $description = $request->input('pageDescription');
        //Get the ContentArea that the request will edit
        $currentPage = Page::find($id);
        //replace all the params inside the ContentArea.
        $currentPage->name = $name; $currentPage->alias = $alias;
        $currentPage->description = $description;
        //save that ContentArea
        $currentPage->save();
        //make a new modification record
        PageModification::create(['modifiedBy' => Auth::user()->id, 'pageModified' => $id]);
        //and finally redirect back to Index
        return redirect('/manage/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $currentPage = Page::find($id);
        $articleReferences = Article::where('page', $currentPage->id)->get();
        foreach($articleReferences as $article){
            $article->page = null; //set reference to No Page
            $article->save();
        }
        $modifications = PageModification::where('pageModified', $currentPage->id)->get();
        foreach($modifications as $modification){
            $modification->delete();
        }
        $currentPage->delete();
        return redirect('/manage/pages');
    }
}
