@extends('layouts.cmsTemplate')

@section('main')
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <h1>Manage CSS Templates</h1>
        </div>
    </div>
    <div class="col-xs-12">
        <label>Select CSS Template</label>
        <br>
        <ul class="list-group">
            @foreach ($cssTemplates as $cssTemplate)
                <li class="list-group-item list-item">
                    <a href="templates/{{$cssTemplate->id}}/edit" data-url="/getCssTemplateInfo/{{$cssTemplate->id}}">{{$cssTemplate->name}}</a>
                    <form class="pull-right" method="POST" action="templates/{{$cssTemplate->id}}" onsubmit="return confirm('Confirm Delete?')">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="X" class="btn btn-default">
                    </form>
                </li>
            @endforeach
        </ul>
        <button onClick="location.href='/manage/templates/create'" type="button" class="btn btn-default">New CSS Template</button>
    </div>
</div>
@stop