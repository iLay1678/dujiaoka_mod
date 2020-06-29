@include('amazeui.layouts._header')
@section('notice')

@show

<div class="am-container" style="min-height: 500px;">
    @yield('content')
</div>

@include('amazeui.layouts._footer')
@section('tpljs')

@show
