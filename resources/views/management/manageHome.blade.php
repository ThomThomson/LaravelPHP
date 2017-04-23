@extends('layouts.cmsTemplate')
@section('main')
@if(Auth::user())
    <div class="jumbotron text-center">
        <h1>Welcome {{Auth::user()->fName}}!</h1>
        <h2>To your back-end management</h2>
        <h3>Check out the links up top to get started</h3>
    </div>
@endif
@stop
