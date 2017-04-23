@extends('layouts.frontendTemplate')

@section('frontendMain')

    <html lang="en">
        <head>
        <title>Page not Found</title>
        <style>
            @if ($activeTemplate != null)
                {{$activeTemplate->cssContent}}
            @endif
        </style>
        </head>
        <body>
            <div class="jumbotron">
                <h1>
                    Page not found!
                </h1>
            </div>
        </body>
    </html>

@endsection