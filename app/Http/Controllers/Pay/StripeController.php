<?php

namespace App\Http\Controllers\Pay;
require_once('lib/stripe/init.php');

use App\Models\Pays;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class StripeController extends PayController
{

    public function gateway($payway, $oid)
    {


        $check = $this->checkOrder($payway, $oid);
        if ($check !== true) {
            return $this->error($check);
        }
        //构造要请求的参数数组，无需改动
        switch ($this->payInfo['pay_check']) {
            case 'wx':
            case 'alipay':
            default:
                try {
                    \Stripe\Stripe::setApiKey($this->payInfo['merchant_id']);
                    $amount = numner_format((float)$this->orderInfo['actual_price'] * 100,2);
                    $price = (float)$this->orderInfo['actual_price'];
                    $usd=number_format($this->getUsdCurrency($this->orderInfo['actual_price']), 2)*100;
                    $orderid = $this->orderInfo['order_id'];
                    $pk = $this->payInfo['merchant_id'];
                    $return_url = site_url() . $this->payInfo['pay_handleroute'] . '/return_url/?orderid=' . $this->orderInfo['order_id'];
                    $html = "<html class=\"js cssanimations\"><head lang=\"en\">
  <meta charset=\"UTF-8\">
  <title>收银台</title>
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <meta name=\"format-detection\" content=\"telephone=no\">
  <meta name=\"renderer\" content=\"webkit\">
  <meta http-equiv=\"Cache-Control\" content=\"no-siteapp\">
  <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/amazeui@2.7.2/dist/css/amazeui.min.css\">
  <style>
    @media only screen and (min-width: 641px) {
      .am-offcanvas {
        display: block;
        position: static;
        background: none;
      }

      .am-offcanvas-bar {
        position: static;
        width: auto;
        background: none;
        -webkit-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
      }
      .am-offcanvas-bar:after {
        content: none;
      }

    }

    @media only screen and (max-width: 640px) {
      .am-offcanvas-bar .am-nav>li>a {
        color:#ccc;
        border-radius: 0;
        border-top: 1px solid rgba(0,0,0,.3);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.05)
      }

      .am-offcanvas-bar .am-nav>li>a:hover {
        background: #404040;
        color: #fff
      }

      .am-offcanvas-bar .am-nav>li.am-nav-header {
        color: #777;
        background: #404040;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.05);
        text-shadow: 0 1px 0 rgba(0,0,0,.5);
        border-top: 1px solid rgba(0,0,0,.3);
        font-weight: 400;
        font-size: 75%
      }

      .am-offcanvas-bar .am-nav>li.am-active>a {
        background: #1a1a1a;
        color: #fff;
        box-shadow: inset 0 1px 3px rgba(0,0,0,.3)
      }

      .am-offcanvas-bar .am-nav>li+li {
        margin-top: 0;
      }
    }

    .my-head {
      margin-top: 40px;
      text-align: center;
    }

    .am-tab-panel{
      text-align:center;
      margin-top:50px;
      margin-bottom:50px;
    }

    .my-footer {
      border-top: 1px solid #eeeeee;
      padding: 10px 0;
      margin-top: 10px;
      text-align: center;
    }


  </style>
<link type=\"text/css\" rel=\"stylesheet\" href=\"https://checkout.stripe.com/v3/checkout/button-qpwW2WfkB0oGWVWIASjIOQ.css\"></head>
<body>
<header class=\"am-g my-head\">
  <div class=\"am-u-sm-12 am-article\">
    <h1 class=\"am-article-title\">收银台</h1>
  </div>
</header>
<hr class=\"am-article-divider\">
<div class=\"am-container\">
    <h2>付款信息<div class=\"am-topbar-right\">¥{$price}</div></h2>
    <p><small>订单编号：$orderid</small></p>
  <div class=\"am-tabs\" data-am-tabs=\"\">
  <ul class=\"am-tabs-nav am-nav am-nav-tabs\">
    <li class=\"am-active\"><a href=\"#alipay\">Alipay 支付宝</a></li>
    <li class=\"request-wechat-pay\"><a href=\"#wcpay\">微信支付</a></li>
    
    
</ul>

  <div class=\"am-tabs-bd am-tabs-bd-ofv\" style=\"touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);\">
    <div class=\"am-tab-panel am-active\" id=\"alipay\">
        
          <a class=\"am-btn am-btn-lg am-btn-warning am-btn-primary\" id=\"alipaybtn\" href=\"#\">进入支付宝付款</a>
       
        <p></p>
    </div>
    <div class=\"am-tab-panel am-fade\" id=\"wcpay\">
        <div class=\"text-align:center; margin:0 auto; width:60%\">
          <div class=\"wcpay-qrcode\" style=\"text-align: center; \" data-requested=\"0\">
              正在加载中...
          </div>
         </div>
    </div>
    
        

    

    
     </div>
</div>
</div>

<script src=\"https://cdn.jsdelivr.net/npm/jquery@2.1.4/dist/jquery.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/jquery.qrcode@1.0.3/jquery.qrcode.min.js\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/amazeui@2.7.2/dist/js/amazeui.min.js\"></script>
<script src=\"https://js.stripe.com/v3/\"></script>
<script>
var stripe = Stripe('$pk');
var source='';
(function() {
       stripe.createSource({
          type: 'alipay',
          amount: $amount,
          currency: 'cny',
          // 这里你需要渲染出一些用户的信息，不然后期没法知道是谁在付钱
          owner: {
            name: '$orderid',
          },
          redirect: {
            return_url: '$return_url',
          },
        }).then(function(result) {
          $(\"#alipaybtn\").attr(\"href\",result.source.redirect.url);
        });

    })();
function paymentcheck(){

  $.ajax({
    url: '/pay/stripe/check/?orderid=$orderid&source='+source,
    type: 'GET',
    success: function (result) {
       if(result==\"success\"){
      $(\".wcpay-qrcode\").html(\"\");
      $(\".wcpay-qrcode\").html(\"<p class='am-alert am-alert-success'>支付成功，正在跳转页面</p>\");
      window.setTimeout(function(){location.href=\"/searchOrderById?order_id=$orderid\"},800);
    }else{
      setTimeout(\"paymentcheck()\", 1000);
    }
    }
});
}

$(\".request-wechat-pay\").click(function(){
  if( $(\".wcpay-qrcode\").data(\"requested\")==0 ){
    stripe.createSource({
      type: 'wechat',
      amount:$usd,
      currency: 'usd',
      owner: {
        name: '$orderid'
      },
    }).then(function(result) {
      if(result.source.id){
        $(\".wcpay-qrcode\").html(\"<p class='am-alert am-alert-success'>打开微信 - 扫一扫</p>\");
        $(\".wcpay-qrcode\").qrcode(result.source.wechat.qr_code_url);
        $(\".wcpay-qrcode\").data(\"requested\",1);

        $(\".wcpay-qrcode\").data(\"sid\",result.source.id);
        $(\".wcpay-qrcode\").data(\"scs\",result.source.client_secret);
        source=result.source.id;
        setTimeout(\"paymentcheck()\", 3000);
      }else{
        alert(\"微信支付加载失败\");
        $(\".wcpay-qrcode\").html(\"<p class='am-alert am-alert-danger'>加载失败，请刷新页面。</p>\");
      }
      
      // handle result.error or result.source
    });
  }
});



</script>


</body></html>";

                    return $html;
                } catch (\Exception $e) {
                    return $this->error('支付通道异常~ ' . $e->getMessage());
                }
                break;
        }
    }

    public function returnUrl(Request $request)
    {

        $data = $request->all();
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['orderid']), true);
        if (!$cacheord) {
            return redirect(site_url() . 'searchOrderById?order_id=' . $data['orderid']);
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
        \Stripe\Stripe::setApiKey($payInfo['merchant_pem']);
        $source_object = \Stripe\Source::retrieve($data['source']);
        //die($source_object);
        if ($source_object->status == 'chargeable') {
            \Stripe\Charge::create([
                'amount' => $source_object->amount,
                'currency' => $source_object->currency,
                'source' => $data['source'],
            ]);
            if ($source_object->owner->name == $data['orderid']) {
                $this->successOrder($data['orderid'], $source_object->id, $source_object->amount / 100);
            }
        }
        return redirect(site_url() . 'searchOrderById?order_id=' . $data['orderid']);
    }

    public function check(Request $request)
    {

        $data = $request->all();
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['orderid']), true);
        if (!$cacheord) {
            //可能已异步回调成功，跳转
            return 'success';
        } else {
            $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
            \Stripe\Stripe::setApiKey($payInfo['merchant_pem']);
            $source_object = \Stripe\Source::retrieve($data['source']);
            if ($source_object->status == 'chargeable') {
                \Stripe\Charge::create([
                    'amount' => $source_object->amount,
                    'currency' => $source_object->currency,
                    'source' => $data['source'],
                ]);
            }
            if ($source_object->status == 'consumed' && $source_object->owner->name == $data['orderid']) {
                $this->successOrder($data['orderid'], $source_object->id, $cacheord['actual_price']);
                return 'success';
            } else {
                return 'fail';
            }
        }

    }
     /**
     * 根据RMB获取美元
     * @param $cny
     * @return float|int
     * @throws \Exception
     */
    public function getUsdCurrency($cny)
    {
        $client = new Client();
        $res = $client->get('https://m.cmbchina.com/api/rate/getfxrate');
        $fxrate = json_decode($res->getBody(), true);
        if (!isset($fxrate['data'])) {
            throw new \Exception('汇率接口异常');
        }
        $dfFxrate = 0.13;
        foreach ($fxrate['data'] as $item) {
            if ($item['ZCcyNbr'] == "美元") {
                $dfFxrate = 100 / $item['ZRtcOfr'];
                break;
            }
        }
        return $cny * $dfFxrate;
    }


}
