<div class="container mg20">
    <ol class="breadcrumb">
        @foreach($breadcrumbarr as $k=>$item)
            <li @if($item['is_end']==1) class="active" @endif>@if($item['is_end']==1) {{$item['title']}} @else <a href="{{url($item['url'])}}" >{{$item['title']}}</a> @endif</li>
        @endforeach
    </ol>
</div>