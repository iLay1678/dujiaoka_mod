@extends('amazeui.layouts.default')
@section('content')
<script>
    document.title = '{{ $title }} - '+document.title;
</script>
<div class="am-panel am-panel-default" style="margin-top:20px;">
    <div class="am-panel-bd">
    <article class="am-article">
  <div class="am-article-hd">
    <h1 class="am-article-title">{{ $title }}</h1>
    <p class="am-article-meta">{{ __('system.update_time') }}：{{$updated_at}}</p>
    <hr class="am-article-divider">
  </div>

  <div class="am-article-bd">
    {!! $content !!}
  </div>
</article>
    
    </div>
</div>

@stop

@section('tpljs')
    <script>

    </script>
@stop
