<?php

namespace App\Http\Controllers;

use App\CssTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\CssTemplateModification;
use App\Http\Requests;

class cssTemplateController extends Controller
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
        $cssTemplates = CssTemplate::all();
        return view('management.viewCssTemplates', compact('cssTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('management.editCssTemplate');
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
            'cssTemplateName' => 'required',
            'cssTemplateActive' => 'required',
            'cssTemplateContent' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('cssTemplateName');
        $active = $request->input('cssTemplateActive');
        if($active == 1){//deactivate all other templates if this one was made active
            foreach(CssTemplate::all() as $currentCss){
                $currentCss->active = 0;
                $currentCss->save();
            }
        }
        $cssContent = $request->input('cssTemplateContent');
        //Create a new Css Template with that input
        CssTemplate::create(['name' => $name, 'active' => $active, 'cssContent' => $cssContent,
            'createdBy' => Auth::id()]);
        return redirect('manage/templates');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $cssTemplate = CssTemplate::find($id);
        return $cssTemplate;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $cssTemplate = CssTemplate::find($id);
        $createdBy = User::find($cssTemplate->createdBy);
        $modificationList = CssTemplateModification::with('User')->where('cssTemplateModified', $id)->orderBy('created_at', 'desc')->get();
        return view('management.editCssTemplate', compact('cssTemplate', 'createdBy', 'modificationList'));
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
            'cssTemplateName' => 'required',
            'cssTemplateActive' => 'required',
            'cssTemplateContent' => 'required'
        ]);
        //Take input from the request
        $name = $request->input('cssTemplateName');
        $active = $request->input('cssTemplateActive');
        $cssContent = $request->input('cssTemplateContent');
        if($active == 1){//deactivate all other templates if this one was made active
            foreach(CssTemplate::all() as $currentCss){
                $currentCss->active = 0;
                $currentCss->save();
            }
        }
        //Get the ContentArea that the request will edit
        $currentTemplate = CssTemplate::find($id);
        //replace all the params inside the ContentArea.
        $currentTemplate->name = $name; $currentTemplate->active = $active;
        $currentTemplate->cssContent = $cssContent;
        //save that ContentArea
        $currentTemplate->save();
        //make a new modification record
        CssTemplateModification::create(['modifiedBy' => Auth::user()->id, 'cssTemplateModified' => $id]);
        //and finally redirect back to Index
        return redirect('manage/templates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $currentTemplate = CssTemplate::find($id);
        $modifications = CssTemplateModification::where('cssTemplateModified', $currentTemplate->id)->get();
        foreach($modifications as $modification){
            $modification->delete();
        }
        $currentTemplate->delete();
        return redirect('manage/templates');
    }
}
