@extends('amazeui.layouts.default')
@section('content')
<script>
    document.title = '{{ __('system.article_page') }} - '+document.title;
</script>
<div class="am-panel am-panel-default" style="margin-top:20px;">
  <div class="am-panel-hd">
    <h3 class="am-panel-title"><h1>{{ __('system.article_page') }}</h1></h3>
  </div>
  
    <ul class="am-list am-list-static">
        @foreach($pages as $page)
   <li class="am-panel-bd">
    <h2>
        <a href="/pages/{{$page['tag']}}.html">{{$page['title']}}</a>
    </h2>
    <span>{{$page['created_at']}}</span>
   
  </li>
    @endforeach
  </ul>
</div>
@stop

@section('tpljs')
    <script>

    </script>
@stop

