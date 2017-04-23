@extends('layouts.cmsTemplate')

@section('main')

    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Manage Pages</h1>
            </div>
        </div>
        <div class="col-xs-12">
            @if(isset($page))
                <form action="/manage/pages/{{$page->id}}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="/manage/pages" method="POST">
            @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="pageName"  value="{{$page->name or ''}}">
                </div>
                <div class="form-group">
                    <label for="alias">Alias:</label>
                    <input type="text" class="form-control" name="pageAlias" value="{{$page->alias or ''}}">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea rows="5" class="form-control" name="pageDescription">{{$page->description or ''}}</textarea>
                </div>
                    @if(isset($page))
                        <div class="form-group">
                            <label>Created By:</label>
                            <span>{{$createdBy->fName or ''}} {{$createdBy->lName or ''}}</span>
                        </div>
                        <div class="form-group">
                            <label>Date Created:</label>
                            <span>{{$page->created_at or ''}}</span>
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