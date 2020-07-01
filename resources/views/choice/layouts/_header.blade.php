<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{{ config('webset.title') }}</title>
    <meta name="Keywords" content="{{ config('webset.keywords')  }}">
    <meta name="Description" content="{{ config('webset.description')  }}">
    <link rel="stylesheet" href="/assets/layui/css/layui.css">
    <link rel="stylesheet" href="/assets/style/main.css?v=1.06">
    <link href="/favicon.png" rel="icon" type="image/png">
    @if(\request()->server()['REQUEST_SCHEME'] == "https")
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
</head>
<body>
   <div class="fly-header layui-bg-black">
        <div class="layui-container">
             <div class="">
                 <a class="fly-logo" href="/"><img src="/logo.png"></a>
             </div>
            <ul class="layui-nav fly-nav" id="webmenu">
				<li></li>
                 <li class="layui-nav-item layui-hide-xs layui-nav-item @if(\Illuminate\Support\Facades\Request::path() == '/') layui-this @endif">
                    <a href="/">{{__('system.home_page')}}</a>
                </li>
                <li class="layui-nav-item layui-hide-xs @if(\Illuminate\Support\Facades\Request::path() == 'searchOrder') layui-this @endif">
                    <a href="{{ url('searchOrder') }}">{{ __('system.order_search') }}</a>
                </li>
                <li class="layui-nav-item layui-hide-xs @if(\Illuminate\Support\Facades\Request::path() == 'pages') layui-this @endif">
                    <a href="{{ url('pages') }}">{{ __('system.article_page') }}</a>
                </li>
            <span class="layui-nav-bar"></span></ul>
			<ul class="layui-nav fly-nav-user">
				<li class="layui-nav-item layui-hide-lg layui-hide-md layadmin-flexible">
					<a href="javascript:;" title="侧边伸缩">
					<i class="layui-icon layui-icon-spread-left" id="main-menu-mobile-switch" style="font-size: 16px;"></i>
					</a>
				</li>
			 <span class="layui-nav-bar"></span></ul>
        </div>
    </div>
    <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="main-menu" id="main-menu-mobile" style="display: none;z-index: 19891016;width: 100%;text-align: center">
  <li class="layui-nav-item layui-nav-itemed">
    <!-- <a href="javascript:;">主菜单</a> -->
    <dl class="layui-nav-child">
				<dd><a href="/">{{__('system.home_page')}}</a></dd>
		<dd><a href="{{ url('searchOrder') }}">{{ __('system.order_search') }}</a></dd>
		<dd><a href="{{ url('pages') }}">{{ __('system.article_page') }}</a></dd>
	</dl>
  </li>
<span class="layui-nav-bar"></span></ul>
 <div class="site-mobile-shade"></div>
