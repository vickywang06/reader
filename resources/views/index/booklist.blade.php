@extends('common/layout_one')
@section('title')
    {{$title}}
    @stop
@section('content')
    {{-- 引入面包屑导航 --}}
    @include("common/breadcrumb")
    <div class="container">
        <div class="catediv">
            @foreach($catelist as $v)
                <span>@if($catename!=$v['name'])<a class="com-a"  href="{{url('booklist',['catename'=>$v['name']])}} ">{{$v['name']}}</a>@else <span class="active">{{$v['name']}}</span> @endif</span>
                @endforeach
        </div>
    </div>
    <div class="container mg20">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$title}}小说列表</h3>
                    </div>
                    <div class="panel-body com-h390">
                        @foreach($detaillist as $v)
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object left-book-img" src="{{$v['cover']}}" alt="{{$v['name']}}" style="width:80px;" >
                                </a>
                            </div>
                            <div class="media-body" style="position:relative">
                                <h4 class="media-heading"><span class="ellips">{{$v['name']}}</span><span style="font-size:13px;" class="author">作者：<span style="color:red;">{{$v['author']}}</span></span></h4>
                                <div class="desc320">{{str_limit($v['desc'],320,'...')?:'暂无简介'}}</div>
                                <div class="desc120" hidden>{{str_limit($v['desc'],50,'...')?:'暂无简介'}}</div>
                                <p class="ab-bottom">点击量：<span >{{$v['total_click']}}</span></p>
                            </div>
                        </div>
                            @endforeach
                    </div>
                    <div class="panel-footer">
                            <nav aria-label="Page navigation" style="text-align:center;">
                               {!! $pagehtml !!}
                            </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stop