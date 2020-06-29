@extends('amazeui.layouts.default')

@section('content')
<div class="am-panel am-panel-default" style="margin-top:20px;">
    <div class="am-panel-bd">{{ $title }}：<hr>
    <p class="product-info" style="text-align: center">
                            <span class="product-price">{{ $content }}</span>
                        </p>
                        <p class="errpanl" style="text-align: center">
                            @if(!$url)
                                <a href="javascript:history.back(-1);"  class="layui-btn layui-btn-sm">{{ __('system.back_btn') }}</a>
                            @else
                                <a href="{{ $url }}"  class="layui-btn layui-btn-sm">{{ __('system.back_btn') }}</a>
                            @endif
                        </p>
    </div>
@stop
