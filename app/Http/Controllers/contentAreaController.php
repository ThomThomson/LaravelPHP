<?php

namespace App\Http\Controllers;

use App\ContentArea;
use App\ContentAreaModification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Article;
use App\Http\Requests;

class contentAreaController extends Controller
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
        $contentAreas = ContentArea::with('createdBy')->get();
        return view('management.viewContentAreas', compact('contentAreas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('management.editContentArea');
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
            'contentAreaName' => 'required',
            'contentAreaAlias' => 'required',
            'contentAreaPageOrder' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('contentAreaName');
        $alias = $request->input('contentAreaAlias');
        $order = $request->input('contentAreaPageOrder');
        $description = $request->input('contentAreaDescription');
        //Create a new Content Area with that input
        ContentArea::create(['name' => $name, 'alias' => $alias, 'order' => $order,
            'description' => $description, 'createdBy' => Auth::id()]);
        return redirect('manage/areas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $contentArea = ContentArea::find($id);
        return $contentArea;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $contentArea = ContentArea::find($id);
        $createdBy = User::find($contentArea->createdBy);
        $modificationList = ContentAreaModification::with('User')->where('contentAreaModified', $id)->orderBy('created_at', 'desc')->get();
        return view('management.editContentArea', compact('contentArea', 'createdBy', 'modificationList'));
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
            'contentAreaName' => 'required',
            'contentAreaAlias' => 'required',
            'contentAreaPageOrder' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('contentAreaName');
        $alias = $request->input('contentAreaAlias');
        $description = $request->input('contentAreaDescription');
        $order = $request->input('contentAreaPageOrder');
        //Get the ContentArea that the request will edit
        $currentArea = ContentArea::find($id);
        //replace all the params inside the ContentArea.
        $currentArea->name = $name; $currentArea->alias = $alias;
        $currentArea->description = $description; $currentArea->order = $order;
        //save that ContentArea
        $currentArea->save();
        //make a new modification record
        ContentAreaModification::create(['modifiedBy' => Auth::user()->id, 'contentAreaModified' => $id]);
        //and finally redirect back to Index
        return redirect('manage/areas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $currentArea = ContentArea::find($id);
        $articleReferences = Article::where('contentArea', $currentArea->id)->get();
        foreach($articleReferences as $article){
            $article->contentArea = null; //set reference to No Content Area
            $article->save();
        }
        $modifications = ContentAreaModification::where('contentAreaModified', $currentArea->id)->get();
        foreach($modifications as $modification){
            $modification->delete();
        }
        $currentArea->delete();
        return redirect('manage/areas');
    }
}
