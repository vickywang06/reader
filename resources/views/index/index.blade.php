@extends('common/layout_one')
@section('title','首页')
@section('content')
    <div class="container mg20">
        <div class="row">
            @foreach($catelist as $v)
            <div class="col-sm-4 col-xs-12">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$v['name']}}</h3>
                    </div>
                    <div class="panel-body com-h390">
                        <ul class="com-ul">
                            @foreach($v['list'] as $k2=>$v2)
                            <li><span @if(in_array($k2,[0,1,2])) class="highlight" @endif>{{$k2+1}}</span>{{$v2['name']}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <p class="tright"><a class="com-a" href="{{url('booklist',['catename'=>$v['name']])}}">查看更多>></a></p>
                    </div>
                </div>
            </div>
                @endforeach
        </div>
    </div>
@stop