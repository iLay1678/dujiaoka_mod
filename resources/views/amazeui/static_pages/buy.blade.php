@extends('amazeui.layouts.default')
@section('notice')
@include('amazeui.layouts._notice')
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
<div class="good-trade">
                    <form  class="am-form-inline layui-form" action="{{ url('postOrder') }}" method="post" style="padding:10px;margin-top: 20px;">
                        <div class="am-container">
                            <div class="am-g">

                                <div class="am-u-sm-12 am-u-md-4 am-u-lg-4 trade-goodimg am-u-end" style="padding:10px">

<img style="border-radius:3px;box-shadow:rgba(0,0,0,0.15) 0 0 8px;background:#FBFBFB;border:1px solid #ddd;padding:5px;" src="{{ \Illuminate\Support\Facades\Storage::disk('admin')->url($pd_picture) }}" width="100%" height="100%">


                                </div>
                                <div class="am-u-sm-12 am-u-md-8 am-u-lg-8  am-u-end" style="padding:10px">
                                    <!-- 网格开始 -->
                                    <span id="goodsname">{{ $pd_name }}</span>

                                <br><small class="attributelist">
                                @if($pd_type == 1)
                                <span class="am-badge am-badge-success"><i class="am-success am-icon-shield"></i>{{ __('system.automatic_delivery') }}</span>
                                @else
                                <span class="am-badge am-badge-success"><i class="am-success am-icon-shield"></i>{{ __('system.charge') }}</span>
                                @endif</small>                                    <p class="trade-goodinfo">
                                        <span style="color:#6c6c6c">{{ __('system.price') }}：</span>
                                        <span class="trade-price">¥<span id="price">{{ $actual_price }}</span></span>
                                        @if($actual_price < $cost_price )
                                        <del>¥ {{ $cost_price }}</del>
                                        @endif
                                        <span style="float:right;">
                                           <span style="color:#6C6C6C">{{__('system.in_stock')}}：{{ $in_stock }}</span>

                                        </span><br>
                                         <span class="am-badge am-badge-danger query-pifa">{{ __('system.see_wholesale_discount') }}</span>
                                         <br>
                                          <span style="color:#6C6C6C">{{ __('system.sales') }}:<span id="salesvolume">{{ $sales_volume }}</span></span><br>



                                    </p>

<div class="am-tab-panel am-fade am-in am-active">
     {{ csrf_field() }}
                                @if(!empty($wholesale_price) && is_array($wholesale_price))
                                    
                                        @foreach($wholesale_price as $ws)
                                            <div class="pifa layui-hide">{{ __('system.purchase_quantity') }}{{ $ws['number'] }} {{__('system.the_above')}},{{ __('system.each') }}¥{{ $ws['price']  }}</div>
                                        @endforeach
                                    @else
                                    <div class="pifa layui-hide">{{ __('system.no_wholesale_discount') }}</div>
                                    @endif
                                            <div class="am-form-group">
                                                <label class="">{{ __('system.quantity') }}</label>
                                                <div class="">
                                                    <input type="number" name="order_number" required
                                                           lay-verify="required|order_number" placeholder=""
                                                           value="1" autocomplete="off" class="layui-input" min="1" max="{{ $in_stock }}">
                                                </div>
                                            </div>
                                            <div class="am-form-group">
                                                <label class="">{{ __('system.email') }}</label>
                                                
                                                    <input type="hidden" name="pid" value="{{ $id }}">
                                                    <input type="email" name="account" value="" required
                                                           lay-verify="required|email" placeholder="{{ __('system.email') }}"
                                                           autocomplete="off" class="layui-input">
                                               
                                            </div>
                                            
                                            <div class="am-form-group">
                                                <label class="">{{ __('system.search_password') }}</label>
                                                <div class="">
                                                    <input type="password" name="search_pwd" value="" required
                                                           lay-verify="required" placeholder="{{ __('prompt.set_search_password') }}"
                                                           autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            
                                            <div class="am-form-group">
                                                <label class="">{{ __('system.promo_code') }}</label>
                                                <div class="">
                                                    <input type="text" name="coupon_code" placeholder="{{ __('prompt.have_promo_code') }}"
                                                           value="" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                       


                                        
                                            @if($pd_type == 2  && is_array($other_ipu))
                                            @foreach($other_ipu as $ipu)
                                            
                                            <div class="am-form-group">
                                                <label class="">{{ $ipu['desc'] }}</label>
                                                <div class="">
                                                    <input type="text" name="{{ $ipu['field'] }}"
                                                           @if($ipu['rule'] !== false) required
                                                    lay-verify="required"
                                                    @endif placeholder="{{ $ipu['desc'] }}" value=""
                                                    autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            
                                            @endforeach

                                            @endif
                                        

                                        
                                         
                                        <div class="am-form-group">
                                          <label class="">{{ __('system.payment_method') }}</label><br>
                                               <select lay-verify="payway" name="payway">
                                                         <option value="">{{ __('prompt.please_select_mode_of_payment') }}</option>
                                                         @foreach($payways as $way)
                                                             <option value="{{ $way['id'] }}">{{ $way['pay_name'] }}</option>
                                                         @endforeach
                                                     </select>
                                        </div>

                                        @if(config('app.shgeetest'))
                                        <div class="am-form-group" style="position: relative;">
                                            <label for="L_vercode" class="">{{ __('system.behavior_verification') }}</label>
                                            <div class="">
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
                                        @if(config('webset.verify_code') == 1)
                                        <br>
                                        
                                        <div class="am-form-group">
                                            <label class="">{{ __('system.verify_code') }}</label>
                                            <div class="am-form-inline">
                                            <div class="am-form-group">
                                                <input type="text" name="verify_img" value="" required
                                                       lay-verify="required" placeholder="{{ __('system.verify_code') }}"
                                                       autocomplete="off"
                                                       class="layui-input">
                                            </div>
                                            <div class="buy-captcha am-form-group">
                                                <img class="captcha-img" src="{{ captcha_src('buy') }}"
                                                     onclick="refresh()">
                                            </div>
                                            <script>
                                            function refresh() {
                                                $('img[class="captcha-img"]').attr('src', '{{ captcha_src('buy') }}' + Math.random());
                                            }
                                        </script>
                                        </div>
                                        </div>
                                        @endif
                                
                                        
                                         
                                        <div class="layui-form">
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
                                        </div>
                                        
                                        <div class="am-form-group">
                                            
                                            <button class="layui-btn layui-btn-danger" id="buy"
                                                    lay-submit
                                                    lay-filter="postOrder"><span class="am-icon-shopping-cart"></span>{{ __('system.order_now') }}
                                            </button>
                                            <button type="reset" class="layui-btn layui-btn-primary">{{ __('system.reset_order') }}</button>
                                        </div>


                                    <!-- 网格结束 -->


                                </div>
                            </div>
                        </div>

                    
              </div></form>
                <div class="am-panel am-panel-default" style="border-radius:0px;border:0px;">
                        <div class="am-tabs" data-am-tabs="{noSwipe: 1}" id="doc-tab-demo-1">
  <ul class="am-tabs-nav am-nav am-nav-tabs">
    <li class="am-active"><a href="javascript: void(0)">{{ __('system.product_desciption') }}</a></li>
    
    
  </ul>

  <div class="am-tabs-bd">
    <div id="product_desc" class="am-tab-panel am-active">
     {!! $pd_info !!}   </div>
    
    
  </div>
</div>
                    </div>

</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="buy_alert">
  <div class="am-modal-dialog">
    <div class="am-modal-hd" id="buy_alert_title">{{ __('prompt.purchase_tips') }}</div>
    <div class="am-modal-bd" id="buy_prompt">{!! $buy_prompt !!}</div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" id="btn_go">确定</span>
    </div>
  </div>
</div>

@stop

@section('tpljs')
<script>
    var pifa_str = $(".pifa").html();
    var instock = {{$in_stock}}
    if (instock < 1) {
        $('#buy').attr('disabled', true);
        $('#buy').addClass('layui-btn-disabled');
    }
    //一般直接写在一个js文件中

    layui.config({
        base: '/assets/layui/'
    }).use(['jquery', 'form', 'layer'], function () {
        var element = layui.element;
        var form = layui.form;
        var sliderVerify = layui.sliderVerify;
        var form = layui.form;
        var layer = layui.layer //获得layer模块
$(".query-pifa").click(function(){
		layer.tips(pifa_str, '.query-pifa',{
	        tips: [2, '#3595CC'],
	        time: 3500
	      });
	})

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
    var buy_prompt = $("#buy_prompt").html();
        if (buy_prompt != "") {
           $("#buy_alert_title").text("{{ __('prompt.purchase_tips') }}");
    $("#buy_alert").modal();
        }
    })

</script>
@stop
