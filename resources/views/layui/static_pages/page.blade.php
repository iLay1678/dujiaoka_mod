@extends('layui.layouts.default')
@section('content')
<script>
    document.title = '{{ $title }} - '+document.title;  
</script>
<div class="">

    <div class="layui-row">
        <!-- PC -->
        <div class="layui-container">
            <div class="layui-card cardcon" style="padding: 16px;">
                <div class="layui-card-body">
                    <h2>{{ $title }}</h2>
                    <hr>
                    {!! $content !!}
                    <p>更新于：{{$updated_at}}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('tpljs')
    <script>

    </script>
@stop