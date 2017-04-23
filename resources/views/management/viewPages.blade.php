@extends('layouts.cmsTemplate')

@section('main')
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <h1>Manage Pages</h1>
        </div>
    </div>
    <div class="col-xs-12">
        <label>Select Page</label>
        <br>
        <ul class="list-group">
            @foreach ($pages as $page)
                <li class="list-group-item list-item">
                    <a href="pages/{{$page->id}}/edit" data-url="/getPageInfo/{{$page->id}}">{{$page->name}}</a>
                    <form class="pull-right" method="POST" action="pages/{{$page->id}}" onsubmit="return confirm('Confirm Delete?')">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="X" class="btn btn-default">
                    </form>

                    <!-- <a href="pages/{{$page->id}}" data-method="DELETE" data-token="{{csrf_token()}}" class="pull-right">X</a> -->
                </li>
            @endforeach

        </ul>
        <button onClick="location.href='/manage/pages/create'" type="button" class="btn btn-default">New Page</button>
    </div>
</div>
@stop