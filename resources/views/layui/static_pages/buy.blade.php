@extends('layui.layouts.default')
@section('notice')
@include('layui.layouts._notice')
@endsection
@section('content')
@if($passwd!=null&&empty($pwd))
<title>{{ config('webset.title') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://cdn.nikm.cn/blog/time/auth.css">
<div class="adcenter"></div>
<div class="lowin">
    <div class="lowin-wrapper">
        <div class="lowin-box lowin-login">
            <div class="lowin-box-inner">
            </div>
        </div>
        <div class="lowin-box lowin-register">
            <div class="lowin-box-inner">
                <form action="" method="post" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <p>{{ config('webset.title') }}</p>
                    <div class="lowin-group">
                        <label>{{__('system.input_product_password')}}</label>
                        <input type="password" name="pwd" class="lowin-input" required="">
                    </div>
                    <button class="lowin-btn">
                        {{__('system.ok_btn')}}
                    </button>
                    <div class="text-foot">
                        <a href="/" class="login-link">{{__('system.home_page')}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@php
exit();
@endphp
@endif
@if($passwd!=null&&!empty($pwd))
@if(!empty($pwd))
@if($pwd!=$passwd)
<title>{{ config('webset.title') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://cdn.nikm.cn/blog/time/auth.css">
<div class="adcenter"></div>
<div class="lowin">
    <div class="lowin-wrapper">
        <div class="lowin-box lowin-login">
            <div class="lowin-box-inner">
            </div>
        </div>
        <div class="lowin-box lowin-register">
            <div class="lowin-box-inner">
                <form action="" method="post" accept-charset="utf-8">
                    {{ csrf_field() }}
                    <p>{{ config('webset.title') }}</p>
                    <div class="lowin-group">
                        <label>{{__('system.wrong_product_password')}}</label>
                        <input type="password" name="pwd" class="lowin-input" required="">
                    </div>
                    <button class="lowin-btn">
                        {{__('system.ok_btn')}}
                    </button>
                    <div class="text-foot">
                        <a href="/" class="login-link">{{__('system.home_page')}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@php
exit();
@endphp

@endif
@endif
@endif
<script>
    document.title = '{{ $pd_name }}_{{ __('system.place_an_order') }} - ' + document.title;
</script>
<div class="layui-row">
    <div class="layui-container">

        <div class="layui-card cardcon">

            <div class="layui-card-body">
                <div class="layui-row">
                    <div class="layui-col-md4 layui-hide-xs">
                        <div class="layui-card">
                            <div class="layui-card-body">
                                <img  style="border-radius:3px;box-shadow:rgba(0,0,0,0.15) 0 0 8px;background:#FBFBFB;border:1px solid #ddd;padding:5px;" src="{{ \Illuminate\Support\Facades\Storage::disk('admin')->url($pd_picture) }}"
                                     width="100%" height="100%">
                            </div>
                            <div class="layui-card-body">
                                <img
                                    src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate(Request::url())) !!}"
                                    width="100%" height="100%">
                                <p style="text-align: center">{{ __('system.mobile_phone_purchase') }}</p>

                            </div>
                        </div>
                    </div>


                    <!-- 商品详细区 -->
                    <div class="layui-col-md8  layui-col-xs12">
                        <div class="layui-card">
                            <div class="layui-card-header" style="line-height: 25px;word-wrap:break-word; word-break:break-all;white-space: normal;height:auto;">
                                @if($pd_type == 1)
                                <span class="layui-badge layui-bg-green">{{ __('system.automatic_delivery') }}</span>
                                @else
                                <span class="layui-badge layui-bg-black">{{ __('system.charge') }}</span>
                                @endif
                                &nbsp;&nbsp;
                                <span style="font-size: 20px;color: #3C3C3C;">{{ $pd_name }}</span>
                                &nbsp;&nbsp;
                            </div>
                            <div class="layui-card-body">
                                <form class="layui-form layui-form-pane" action="{{ url('postOrder') }}"
                                      method="post">
                                    {{ csrf_field() }}
                                    <div class="product-info">
                                        <span style="color:#6c6c6c">{{ __('system.price') }}：</span>
                                        <span class="product-price">¥ {{ $actual_price }}</span>
                                        <span class="product-price-cost-price">¥ {{ $cost_price }}</span>
                                        <span style="color:#6c6c6c">&nbsp;&nbsp;{{__('system.in_stock')}}({{ $in_stock }})</span>
                                    </div>

                                    @if(!empty($wholesale_price) && is_array($wholesale_price))
                                    <div class="product-info">
                                                <span style="color:#F40;font-size: 18px;font-weight: 400"><i
                                                        class="layui-icon layui-icon-praise"></i>{{ __('system.wholesale_discount') }}：</span>
                                        @foreach($wholesale_price as $ws)
                                            <p class="ws-price">{{ __('system.purchase_quantity') }}{{ $ws['number'] }} {{__('system.the_above')}},{{ __('system.each') }}： <span class="layui-badge layui-bg-orange">￥{{ $ws['price']  }}</span></p>
                                        @endforeach

                                    </div>

                                    @endif
                                    <div class="layui-field-box">
                                        <div class="layui-form-item">
                                            <div class="layui-inline">
                                                <label class="layui-form-label">{{ __('system.email') }}</label>
                                                <div class="layui-input-block">
                                                    <input type="hidden" name="pid" value="{{ $id }}">
                                                    <input type="email" name="account" value="" required
                                                           lay-verify="required|email" placeholder="{{ __('system.email') }}"
                                                           autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            <div class="layui-inline">
                                                <label class="layui-form-label">{{ __('system.search_password') }}</label>
                                                <div class="layui-input-block">
                                                    <input type="password" name="search_pwd" value="" required
                                                           lay-verify="required" placeholder="{{ __('prompt.set_search_password') }}"
                                                           autocomplete="off" class="layui-input">
                                                </div>
                                            </div>

                                        </div>


                                        <div class="layui-form-item">
                                            <div class="layui-inline">
                                                <label class="layui-form-label">{{ __('system.quantity') }}</label>
                                                <div class="layui-input-block">
                                                    <input type="number" name="order_number" required
                                                           lay-verify="required|order_number" placeholder=""
                                                           value="1" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            <div class="layui-inline">
                                                <label class="layui-form-label">{{ __('system.promo_code') }}</label>
                                                <div class="layui-input-block">
                                                    <input type="text" name="coupon_code" placeholder="{{ __('prompt.have_promo_code') }}"
                                                           value="" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="layui-form-item">
                                            @if($pd_type == 2  && is_array($other_ipu))
                                            @foreach($other_ipu as $ipu)

                                            <div class="layui-inline">
                                                <label class="layui-form-label">{{ $ipu['desc'] }}</label>
                                                <div class="layui-input-block">
                                                    <input type="text" name="{{ $ipu['field'] }}"
                                                           @if($ipu['rule'] !== false) required
                                                    lay-verify="required"
                                                    @endif placeholder="{{ $ipu['desc'] }}" value=""
                                                    autocomplete="off" class="layui-input">
                                                </div>
                                            </div>

                                            @endforeach

                                            @endif
                                        </div>

                                        
                                         <div class="layui-form-item">
                                             <div class="layui-inline">
                                                 <label class="layui-form-label">{{ __('system.payment_method') }}</label>
                                                 <div class="layui-input-block">
                                                     <select lay-verify="payway" name="payway">
                                                         <option value="">{{ __('prompt.please_select_mode_of_payment') }}</option>
                                                         @foreach($payways as $way)
                                                             <option value="{{ $way['id'] }}">{{ $way['pay_name'] }}</option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
                                        @if(config('app.shcaptcha'))
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">{{ __('system.verify_code') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="verify_img" value="" required
                                                       lay-verify="required" placeholder="{{ __('system.verify_code') }}"
                                                       autocomplete="off"
                                                       class="layui-input">
                                            </div>
                                            <div class="buy-captcha">
                                                <img class="captcha-img" src="{{ captcha_src('buy') }}"
                                                     onclick="refresh()">
                                            </div>
                                            <script>
                                                function refresh() {
                                                    $('img[class="captcha-img"]').attr('src', '{{ captcha_src('
                                                    buy
                                                    ') }}' + Math.random()
                                                )
                                                    ;
                                                }
                                            </script>
                                        </div>
                                        @endif

                                        @if(config('app.shgeetest'))
                                        <div class="layui-form-item" style="position: relative;">
                                            <label for="L_vercode" class="layui-form-label">{{ __('system.behavior_verification') }}</label>
                                            <div class="layui-input-inline">
                                                <input type="text" style="cursor:pointer" readonly=""
                                                       class="layui-input" id="GeetestCaptcha"
                                                       placeholder="{{ __('system.click_to_behavior_verification') }}">
                                            </div>
                                        </div>
                                        <div class="layui-hide">{!! Geetest::render('popup') !!}</div>
                                        <script>$('#GeetestCaptcha').click(function () {
                                                $('.geetest_radar_btn').click();
                                            })</script>
                                        @endif
                                        <!---  <div class="layui-form-item">
                                                <label class="layui-form-label">滑动验证</label>
                                                <div class="layui-input-inline">
                                                    <div id="slider"></div>
                                                </div>
                                            </div>-->


                                        <div class="layui-form-item">
                                            <div class="layui-input-block" style="margin-left: -9px !important;">
                                                <input type="checkbox" checked="" lay-filter="tos" id="tos"
                                                       lay-skin="primary"
                                                       title="{{ __('system.read_and_agree') }} <a href='/pages/tos.html' target='_blank'>《{{ __('system.agreement') }}》</a>">
                                                <div class="layui-unselect layui-form-checkbox layui-form-checked"
                                                     lay-skin="primary"><span>{{ __('system.read_and_agree') }} <a href="/pages/tos.html"
                                                                                         target="_blank">《{{ __('system.agreement') }}》</a></span><i
                                                        class="layui-icon layui-icon-ok"></i></div>
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <button class="layui-btn layui-btn-normal" id="buy"
                                                    lay-submit
                                                    lay-filter="postOrder">{{ __('system.order_now') }}
                                            </button>
                                            <button type="reset" class="layui-btn layui-btn-primary">{{ __('system.reset_order') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                                <ul class="layui-tab-title">
                                    <li class="layui-this">{{ __('system.product_desciption') }}</li>
                                </ul>
                                <div class="layui-tab-content" style="">
                                    <div class="layui-tab-item layui-show">
                                        {!! $pd_info !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>

    </div>
</div>

@stop

@section('tpljs')
<script>

    var instock = {{$in_stock}}
    if (instock < 1) {
        $('#buy').attr('disabled', true);
        $('#buy').addClass('layui-btn-disabled');
    }
    //一般直接写在一个js文件中

    layui.config({
        base: '/assets/layui/'
    }).use(['sliderVerify', 'jquery', 'form', 'layer'], function () {
        var element = layui.element;
        var form = layui.form;
        var sliderVerify = layui.sliderVerify;
        var form = layui.form;
        var layer = layui.layer //获得layer模块
        /*var slider = sliderVerify.render({
            elem: '#slider',
            onOk: function () {//当验证通过回调
                layer.msg("滑块验证通过", {
                    icon: 6
                });
            }
        })*/


        form.verify({
            order_number: function (value, item) {
                if (value == 0) return '{{ __('prompt.purchase_quantity_not_null') }}'
                if (value > instock) return "{{ __('prompt.inventory_shortage') }}"
            },
        })

        form.on('submit(postOrder)', function (data) {

            if (data.field.payway == "") {
                layer.msg("{{ __('prompt.please_select_mode_of_payment') }}", {
                    icon: 5
                })
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            }
            /*if (slider.isOk()) {//用于表单验证是否已经滑动成功
                return true;
            } else {
                return false;
                layer.msg("请先通过滑块验证", {
                    icon: 5
                });
            }*/
        });
        form.on('checkbox(tos)', function (data) {
            if (data.elem.checked) {
                $('#buy').attr('disabled', false);
                $('#buy').removeClass('layui-btn-disabled');
            } else {
                $('#buy').attr('disabled', true);
                $('#buy').addClass('layui-btn-disabled');
            }
            if (instock < 1) {
                $('#buy').attr('disabled', true);
                $('#buy').addClass('layui-btn-disabled');
            }
        });
    @if(!empty($buy_prompt))
        layer.open({
            type: 1,
            shade: false,
            skin: 'layui-layer-lan', //加上边框
            area: ['60%', '50%'], //宽高
            title:  "{{ __('prompt.purchase_tips') }}",
            content: '<div class="buy-prompt">{!! $buy_prompt !!}<div>'
        });
    @endif
    })

</script>
@stop
