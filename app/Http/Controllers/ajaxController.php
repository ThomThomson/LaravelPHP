<?php

namespace App\Http\Controllers;

use App\ContentArea;
use App\CssTemplate;
use Illuminate\Http\Request;
use App\User;
use App\Article;
use App\Page;
use App\Http\Requests;

class ajaxController extends Controller
{

    public function getUserInfo($id) {

        $user = User::find($id);

        return "Email: " . $user->email;

    }

    public function getArticleInfo($id) {

        $article = Article::find($id);

        return "Title: " . $article->title . "<br>" .
        "Description: "  . $article->description;

    }

    public function getPageInfo($id) {

        $page = Page::find($id);

        return "Title: " . $page->title . "<br>" .
        "Alias: " . $page->alias . "<br>" .
        "Description: " . $page->description;

    }

    public function getContentAreaInfo($id) {

        $contentArea = ContentArea::find($id);

        return "Title: " . $contentArea->title . "<br>" .
        "Alias: " . $contentArea->alias . "<br>" .
        "Order: " . $contentArea->order . "<br>" .
        "Description: " . $contentArea->description;

    }

    public function getCssTemplateInfo($id) {

        $cssTemplate = CssTemplate::find($id);

        return "Active: " . ($cssTemplate->active == 1 ? "Yes" : "No");

    }

}
