@extends('layouts.cmsTemplate')

@section('main')
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Manage Articles</h1>
            </div>
        </div>
        <div class="col-xs-12">
            <label>Select Article</label>
            <br>
            <ul class="list-group">

                @foreach ($articles as $article)

                    <li class="list-group-item list-item">
                        <a href="articles/{{$article->id}}/edit" data-url="/getArticleInfo/{{$article->id}}">{{$article->name}}</a>
                        <form class="pull-right" method="POST" action="articles/{{$article->id}}" onsubmit="return confirm('Confirm Delete?')">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" value="X" class="btn btn-default">
                        </form>
                    </li>

                @endforeach

            </ul>
            <button onClick="location.href='/manage/articles/create'" type="button" class="btn btn-default">New Article</button>
        </div>
    </div>
@stop