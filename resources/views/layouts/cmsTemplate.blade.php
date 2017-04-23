<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/basic/jquery.qtip.css"/>
    <style>

        .list-item {
            position: relative;
            height: 50px;
        }

        .list-item a, .list-item input {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .list-item input {
            transform: translateY(-50%) translateX(-100%);
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Front End</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                @if(!empty(Auth::user()))
                    <ul class="nav navbar-nav">
                        @if(Auth::user()->getIsAdminAttribute())
                            <li><a href="/manage/users">Users</a></li>
                        @endif
                        @if(Auth::user()->getIsEditorAttribute())
                            <li><a href="/manage/pages">Pages</a></li>
                            <li><a href="/manage/articles">Articles</a></li>
                            <li><a href="/manage/areas">Content Areas</a></li>
                            <li><a href="/manage/templates">CSS Templates</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/manage"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->fName}} {{Auth::user()->lName}}</a></li>
                        <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
    <div class="container generated">
        <!--Display all errors -->
        @if (count($errors))
            <div class="col-xs-12">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible">
                        <strong>Error: </strong>
                        {{ $error }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                @endforeach
            </div>
        @endif

        @yield('main')
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/basic/jquery.qtip.js"></script>
    <script src='https://cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>tinymce.init({ selector:'.tinyMCE' });</script>
    <script>
        $(document).ready(function(){
            $('.generated li a').each(function() {
                $(this).qtip({
                    content: {
                        text: function(event, api) {
                            $.ajax({
                                url: api.elements.target.attr('data-url') // Use href attribute as URL
                            })
                                    .then(function(content) {
                                        // Set the tooltip content upon successful retrieval
                                        api.set('content.text', content);
                                    }, function(xhr, status, error) {
                                        // Upon failure... set the tooltip content to error
                                        api.set('content.text', status + ': ' + error);
                                    });
                            return 'Loading...'; // Set some initial text
                        }
                    },
                    position: {
                        viewport: $(window)
                    },
                    style: 'qtip-wiki'
                });
            });
        });
    </script>
</body>

</html>