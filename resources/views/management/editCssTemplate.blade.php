@extends('layouts.cmsTemplate')

@section('main')

    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Manage CSS Template</h1>
            </div>
        </div>
        <div class="col-xs-12">
            @if(isset($cssTemplate))
                <form action="/manage/templates/{{$cssTemplate->id}}" method="POST">
                <input type="hidden" name="_method" value="PUT">
            @else
                <form action="/manage/templates" method="POST">
            @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="cssTemplateName">Name:</label>
                    <input type="text" class="form-control" name="cssTemplateName"  value="{{$cssTemplate->name or ''}}">
                </div>
                <div class="row">
                    <div class="form-group col-xs-8">
                        <label for="cssTemplateCssContent">CSS Content:</label>
                        <textarea rows="20" class="form-control" name="cssTemplateContent">{{$cssTemplate->cssContent or ''}}</textarea>
                    </div>
                    <div class="col-xs-4">
                        <h4>Css Notes</h4>
                        <p>The front end contains a few classes you may want to apply styles to:</p>
                        <ul>
                            <li><strong>navBackend:</strong> the bar that includes logout and the backend link</li>
                            <li><strong>navMenu:</strong> the bar that includes links to your pages</li>
                            <li><strong>pageContent:</strong> the container class that wraps all your content</li>
                            <li><strong>Article titles</strong> are in h2 tags</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <label for="cssTemplateActive">Active State:</label>
                    <select class="form-control" name="cssTemplateActive">
                        @if(isset($cssTemplate))
                            @if($cssTemplate->active == 0)
                                <option value="1">Active</option>
                                <option value="0" selected="selected">Inactive</option>
                            @else
                                <option value="1" selected="selected">Active</option>
                                <option value="0">Inactive</option>
                            @endif
                        @else
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        @endif
                    </select>
                </div>
                    @if(isset($cssTemplate))
                        <div class="form-group">
                            <label>Created By:</label>
                            <span>{{$createdBy->fName or ''}} {{$createdBy->lName or ''}}</span>
                        </div>
                        <div class="form-group">
                            <label>Date Created:</label>
                            <span>{{$cssTemplate->created_at or ''}}</span>
                        </div>
                    @endif
                <div class="col-xs-12">
                    <input type="submit" class="btn btn-default" value="Submit">
                </div>
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