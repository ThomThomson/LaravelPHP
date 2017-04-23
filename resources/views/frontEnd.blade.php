@extends('layouts.frontendTemplate')
@section('frontendMain')

    @foreach($contentAreas as $contentArea)
        <div class="{{$contentArea->alias}}">
            @foreach($commonArticles as $article)
                @if($article->contentArea == $contentArea->id)
                    @if(!empty(Auth::user()) && Auth::user()->getIsAuthorAttribute())
                        <div style="display:inline"><a href="manage/articles/{{$article->id}}/edit">edit</a></div>
                    @endif
                    {!! $article->htmlContent!!}
                @endif
            @endforeach
            @foreach($pageArticles as $article)
                @if($article->contentArea == $contentArea->id)
                    <div style="text-align:center">
                        @if(!empty(Auth::user()) && Auth::user()->getIsAuthorAttribute())
                                <div style="display:inline"><a href="manage/articles/{{$article->id}}/edit">edit</a></div>
                        @endif
                        <h2 style="display:inline">{{$article->title}}</h2>
                    </div>
                    {!! $article->htmlContent !!}
                @endif
            @endforeach
        </div>
    @endforeach

@endsection