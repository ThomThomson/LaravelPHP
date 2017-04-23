@extends('layouts.cmsTemplate')

@section('main')

    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Manage Content Area</h1>
            </div>
        </div>
        <div class="col-xs-12">
            @if(isset($contentArea))
                <form action="/manage/areas/{{$contentArea->id}}" method="POST">
                <input type="hidden" name="_method" value="PUT">
            @else
                <form action="/manage/areas" method="POST">
            @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="contentAreaName">Name:</label>
                    <input type="text" class="form-control" name="contentAreaName"  value="{{$contentArea->name or ''}}">
                </div>
                <div class="form-group">
                    <label for="contentAreaAlias">Alias:</label>
                    <input type="text" class="form-control" name="contentAreaAlias" value="{{$contentArea->alias or ''}}">
                </div>
                <div class="form-group">
                    <label for="contentAreaDescription">Description:</label>
                    <textarea rows="5" class="form-control" name="contentAreaDescription">{{$contentArea->description or ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="contentAreaPageOrder">Page Order:</label>
                    <input type="text" class="form-control" name="contentAreaPageOrder" value="{{$contentArea->order or ''}}">
                </div>
                    @if(isset($contentArea))
                        <div class="form-group">
                            <label>Created By:</label>
                            <span>{{$createdBy->fName or ''}} {{$createdBy->lName or ''}}</span>
                        </div>
                        <div class="form-group">
                            <label>Date Created:</label>
                            <span>{{$contentArea->created_at or ''}}</span>
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