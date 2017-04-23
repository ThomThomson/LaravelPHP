<!DOCTYPE html>
<html lang="en">
<head>
    @if(!empty($currentPage))
        <title>{{$currentPage->name}}</title>
    @else
        <title>Page not Found</title>
    @endif
    <style>
        @if ($activeTemplate != null)
            {!! $activeTemplate->cssContent!!}
        @endif
    </style>
</head>
<body>
    <div class="navBackend">
        <ul>
            @if(!empty(Auth::user()))
                <li><a href="#">{{Auth::user()->fName}} {{Auth::user()->lName}}</a></li>
                <li><a href="/logout">Logout</a></li>
            @endif
            @if(!empty(Auth::user()) && (Auth::user()->getIsAdminAttribute() || Auth::user()->getIsEditorAttribute()))
                <li><a href="/manage">CMS Panel</a></li>
            @endif
            @if(!empty(Auth::user()) && Auth::user()->getIsAuthorAttribute())
                <li><a href="/manage/articles/create">New Article</a></li>
            @endif
        </ul>
    </div>
    <header>
        <nav class="navMenu">
            <ul>
                @if(empty(Auth::user()))
                    <li><a href="/login">Login</a></li>
                @endif
                @foreach($pages as $page)
                    @if($page->alias == $currentPage->alias)
                        <li><a href="/{{$page->alias}}" class="active">{{$page->name}}</a></li>
                    @else
                        <li><a href="/{{$page->alias}}">{{$page->name}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </header>
    <main class="pageContent">
        @yield('frontendMain')
    </main>
</body>