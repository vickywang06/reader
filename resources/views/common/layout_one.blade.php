<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>橘子小说网-@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('static/css/bootstrap.min.css') }}" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('static/css/main.css') }}" />
</head>
<body>
    @section('header')
            <nav class="navbar navbar-default">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Brand</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-left">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="警察攻略">
                                <span class="input-group-btn" >
                                  <button class="btn btn-orange" type="button" >搜索</button>
                                </span>
                            </div>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">用户登录</a></li>
                            {{--<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">个人中心 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>--}}
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <div class="navbar-orange">
                <div class="container">
                    <ul class="mynav">
                        <li @if($navtype==1)@endif>首页</li>
                        <li>排行榜单</li>
                        <li>全本小说</li>
                        <li>看过的书</li>
                    </ul>
                </div>
            </div>
    @show



    @section('content')
        
        @show

<script src="{{ asset('static/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('static/js/bootstrap.min.js') }}" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>