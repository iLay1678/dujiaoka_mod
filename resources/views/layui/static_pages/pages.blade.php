@extends('layui.layouts.default')
@section('content')
<script>
    document.title = '{{ __('system.article_page') }} - '+document.title;
</script>
    <div class="layui-row ">
        <div class="layui-container">
            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.article_page') }}</div>
                <div class="layui-card-body">
                    <ul>
                        @foreach($pages as $page)
                            <li>
                                <h2>
                                    <a href="/pages/{{$page['tag']}}.html">{{$page['title']}}</a>
                                </h2>
                                <div class="">
                                    <span>{{$page['created_at']}}</span>
                                </div>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('tpljs')
    <script>

    </script>
@stop

