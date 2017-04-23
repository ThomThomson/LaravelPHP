@extends('layouts.cmsTemplate')

@section('main')
<div class="row">
    <div class="col-xs-12">
        <div class="page-header">
            <h1>Manage Users</h1>
        </div>
    </div>
    <div class="col-xs-12">
        <label>Select user</label>
        <br>
        <ul class="list-group">
            @foreach ($users as $user)
                <li class="list-group-item list-item">
                    <a href="users/{{$user->id}}/edit" data-url="/getUserInfo/{{$user->id}}">{{$user->fName}} {{$user->lName}}</a>
                    <form class="pull-right" method="POST" action="users/{{$user->id}}" onsubmit="return confirm('Confirm Delete?')">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" value="X" class="btn btn-default">
                    </form>
                </li>
            @endforeach
        </ul>
        <button onClick="location.href='/manage/users/create'" type="button" class="btn btn-default">New User</button>
    </div>
</div>
@stop