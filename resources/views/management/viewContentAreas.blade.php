@extends('layouts.cmsTemplate')

@section('main')
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <h1>Manage Content Area</h1>
        </div>
    </div>
    <div class="col-xs-12">
        <label>Select Content Area</label>
        <br>
        <ul class="list-group">
            @foreach ($contentAreas as $contentArea)
                <li class="list-group-item list-item">
                    <a href="areas/{{$contentArea->id}}/edit" data-url="/getContentAreaInfo/{{$contentArea->id}}">{{$contentArea->name}}</a>
                    <form class="pull-right" method="POST" action="areas/{{$contentArea->id}}" onsubmit="return confirm('Confirm Delete?')">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="X" class="btn btn-default">
                    </form>
                </li>
            @endforeach
        </ul>
        <button onClick="location.href='/manage/areas/create'" type="button" class="btn btn-default">New Content Area</button>
    </div>
</div>
@stop