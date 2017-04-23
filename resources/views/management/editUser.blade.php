@extends('layouts.cmsTemplate')

@section('main')

    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Manage Users</h1>
            </div>
        </div>
        <div class="col-xs-12">
            @if(isset($user))
                <form action="/manage/users/{{$user->id}}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
            @else
                <form action="/manage/users" method="POST">
            @endif
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="userFName">First Name:</label>
                    <input type="text" class="form-control" name="userFName"  value="{{$user->fName or ''}}">
                </div>
                <div class="form-group">
                    <label for="userLName">Last Name:</label>
                    <input type="text" class="form-control" name="userLName"  value="{{$user->lName or ''}}">
                </div>
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <input type="text" class="form-control" name="userEmail" value="{{$user->email or ''}}">
                </div>
                <div class="form-group">
                    <label for="userPassword">@if(isset($user))Edit @endif Password:</label>
                    <input type="password" class="form-control" name="userPassword" value="">
                </div>
                <div class="form-group">
                    <label for="userPassword_confirmation">Confirm Password:</label>
                    <input type="password" class="form-control" name="userPassword_confirmation" value="">
                </div>
                @if(isset($user))
                    <div class="form-group">
                        <label>Created By:</label>
                        <span>{{$createdBy->fName or ''}} {{$createdBy->lName or ''}}</span>
                    </div>
                    <div class="form-group">
                        <label>Date Created:</label>
                        <span>{{$user->created_at or ''}}</span>
                    </div>
                @endif
                <div class="form-group">
                    <label class="checkbox-inline"><input type="checkbox" value="1" name="accessLevels[]" {{ $userAccessLevels[0] ? 'checked' : '' }}>Administrator</label>
                    <label class="checkbox-inline"><input type="checkbox" value="2" name="accessLevels[]" {{ $userAccessLevels[1] ? 'checked' : '' }}>Editor</label>
                    <label class="checkbox-inline"><input type="checkbox" value="3" name="accessLevels[]" {{ $userAccessLevels[2] ? 'checked' : '' }}>Author</label>
                </div>
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