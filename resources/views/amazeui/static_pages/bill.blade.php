@extends('amazeui.layouts.default')
@section('content')
<script>
    document.title = '{{ __('system.confirm_order') }} - '+document.title;
</script>
    <div class="layui-row" style="margin-top:20px;">
        <div class="layui-container">

            <div class="layui-card cardcon">
                <div class="layui-card-header">{{ __('system.confirm_order') }}</div>

                <div class="layui-card-body">
                    <div class="product-info">
                        <p style="color: #1E9FFF;font-size: 20px;font-weight: 500; text-align: center" >{{ __('system.note') }}：{{ config('app.order_expire_date') }} {{ __('system.prompt_to_cancel_order') }}！</p>
                    </div>
                    <div class="am-scrollable-horizontal">
                    <table class="am-table am-table-bordered am-table-striped am-table-compact am-text-nowrap" >
                        <colgroup>
                            <col width="30">
                            <col width="60">
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>{{ __('system.order_number') }}：</td>
                            <td>{{ $order_id }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('system.product_name') }}：</td>
                            <td>
                                <span class="layui-badge layui-bg-blue">
                                    {{ $pd_name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('system.commodity_price') }}：</td>
                            <td>
                                <span class="layui-badge layui-bg-orange">
                                    {{ $product_price }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('system.purchase_quantity') }}：</td>
                            <td>x {{ $buy_amount }}</td>
                        </tr>
                        @if(isset($coupon_code))
                        <tr>
                            <td>{{ __('system.promo_code') }}：</td>
                            <td><span class="layui-badge layui-bg-orange">{{ $coupon_code }}</span></td>
                        </tr>
                        <tr>
                            <td>{{ __('system.discounted_price') }}：</td>
                            <td> <span class="layui-badge layui-bg-green">{{ $discount }}</span></td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ __('system.actual_payment') }}：</td>
                            <td><span class="layui-badge layui-bg-red">{{ $actual_price }}</span></td>
                        </tr>
                        <tr>
                            <td>{{ __('system.email') }}：</td>
                            <td>{{ $account }}</td>
                        </tr>
                        @if($other_ipu)
                        <tr>
                            <td>{{ __('system.order_information') }}:</td>
                            <td><p>{{ $other_ipu }}</p></td>
                        </tr>
                        @endif
                        
                        <tr>
                            <td>{{ __('system.payment_method') }}：</td>
                            <td>{{ \App\Models\Pays::find($pay_way)->pay_name }}</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <p class="errpanl" style="text-align: center"><a href="{{ url(\App\Models\Pays::find($pay_way)->pay_handleroute, ['payway' => $pay_way, 'oid' => $order_id]) }}" class="layui-btn layui-btn-sm">{{ __('system.pay_immediately') }}</a></p>

                </div>



            </div>

        </div>
    </div>


@stop

@section('tpljs')
    <script>

    </script>
@stop
