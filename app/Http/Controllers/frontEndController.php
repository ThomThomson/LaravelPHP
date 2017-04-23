<?php

namespace App\Http\Controllers;

use App\ContentArea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Page;
use App\CssTemplate;
use App\Article;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class frontEndController extends Controller
{
    public function enterBackend(){
        if(Auth::user()){
            return view('management.manageHome');
        }else{
            return back();
        }

    }

    public function showPage($alias){
        $pages = Page::all();
        $contentAreas = ContentArea::all();
        $currentPage = Page::where('alias', $alias)->first();
        $activeTemplate = CssTemplate::where('active', 1)->first();
        if(!empty($currentPage)){
            $pageArticles = Article::where('page', $currentPage->id)->orderBy('updated_at', 'desc')->get();
            $commonArticles = Article::where('allPages', true)->get();
            return view('frontEnd', compact('contentAreas', 'commonArticles', 'pageArticles', 'activeTemplate', 'pages', 'currentPage'));
        }else{
            return view('frontend404', compact('pages', 'activeTemplate'));
        }
    }

    public function findIndex(){
        $indexPage = Page::where('alias', 'index')->first();
        if(isset($indexPage)){
            return frontEndController::showPage('index');
        }else{
            $page = Page::orderBy('alias', 'asc')->first();
            return frontEndController::showPage($page->alias);
        }
    }
}
