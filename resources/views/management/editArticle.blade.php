@extends('layouts.cmsTemplate')

@section('main')

    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Manage Articles</h1>
            </div>
        </div>
        <div class="col-xs-12">
            @if(isset($article))
                <form action="/manage/articles/{{$article->id}}" method="POST">
                <input type="hidden" name="_method" value="PUT">
            @else
                <form action="/manage/articles" method="POST">
            @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="articleName">Name:</label>
                    <input type="text" class="form-control" name="articleName"  value="{{$article->name or ''}}">
                </div>
                <div class="form-group">
                    <label for="articleTitle">Title:</label>
                    <input type="text" class="form-control" name="articleTitle" value="{{$article->title or ''}}">
                </div>
                <div class="form-group">
                    <label for="articleDescription">Description:</label>
                    <textarea rows="5" class="form-control" name="articleDescription">{{$article->description or ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="articleHtml">HTML Content:</label>
                    <textarea rows="20" class="form-control tinyMCE" name="articleHtml">{{$article->htmlContent or ''}}</textarea>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <label for="articlePage">Page:</label>
                    <select class="form-control" name="articlePage">
                        <option value='NO_SELECTION'>No Selection</option>
                        @if(!empty($article))
                            @if($article->allPages)
                                <option value='ALL_PAGES' selected="selected">All Pages</option>
                            @else
                                <option value='ALL_PAGES'>All Pages</option>
                            @endif
                        @else
                            <option value='ALL_PAGES'>All Pages</option>
                        @endif
                        @foreach ($pages as $page)
                            @if(isset($article))
                                @if($page->id == $article->page)
                                    <option selected="selected" value="{{$page->id}}">{{$page->name}}</option>
                                @else
                                    <option value="{{$page->id}}">{{$page->name}}</option>
                                @endif
                            @else
                                <option value="{{$page->id}}">{{$page->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <label for="articleContentArea">Content Area:</label>
                    <select class="form-control" name="articleContentArea">
                        <option value='NO_SELECTION'>No Selection</option>
                        @foreach ($contentAreas as $contentArea)
                            @if(isset($article))
                                @if($contentArea->id == $article->contentArea)
                                    <option selected="selected" value="{{$contentArea->id}}">{{$contentArea->name}}</option>
                                @else
                                    <option value="{{$contentArea->id}}">{{$contentArea->name}}</option>
                                @endif
                            @else
                                <option value="{{$contentArea->id}}">{{$contentArea->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                    @if(isset($article))
                        <div class="form-group">
                            <label>Created By:</label>
                            <span>{{$createdBy->fName or ''}} {{$createdBy->lName or ''}}</span>
                        </div>
                        <div class="form-group">
                            <label>Date Created:</label>
                            <span>{{$article->created_at or ''}}</span>
                        </div>
                    @endif
                <input type="submit" class="btn btn-default" value="Submit">
            </form>
        </div>
    </div>

    <!--Modification stuff below -->
    <div class="row">
        <div class="col-xs-12">
            @if(isset($modificationList) and count($modificationList) > 0)
                <div class="page-header">
                    <h1>Modification History</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Modified By</th>
                            <th>Date Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modificationList as $modification)
                            <tr>
                                <td>{{$modification->User->fName}} {{$modification->User->lName}}</td>
                                <td>{{$modification->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@stop