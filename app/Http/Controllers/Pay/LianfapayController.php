<?php

namespace App\Http\Controllers\Pay;

use App\Exceptions\AppException;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LianfapayController extends PayController
{

    public function gateway($payway, $oid)
    {
        $this->checkOrder($payway, $oid);

        //组装支付参数
        switch ($this->payInfo['pay_check']){
            case 'lfwechat':
                $pay_bankcode="901";
                break;
            case 'lfalipay':
                $pay_bankcode="904";
                break;
            default:
                $pay_bankcode="904";

        }
        $parameter = [
            'pay_memberid' => (int)$this->payInfo['merchant_id'],
            'pay_bankcode' => $pay_bankcode,
            'pay_orderid' =>uniqid(mt_rand(), true), 
            'pay_callbackurl' => site_url().'searchOrderById?order_id='.$this->orderInfo['order_id'],
            'pay_notifyurl' => site_url() . $this->payInfo['pay_handleroute'] . '/notify_url',
            'pay_amount' => (float)$this->orderInfo['actual_price'],
            'pay_applydate' => date('Y-m-d H:i:s', time()),
        ];
        ksort($parameter);
        reset($parameter);
        $md5str = "";
        foreach ($parameter as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $md5str=$md5str . "key=" .  $this->payInfo['merchant_pem'];
        $sign = strtoupper(md5($md5str));
        $parameter["pay_md5sign"] = $sign;
        $parameter["pay_productname"] = $this->orderInfo['product_name'];
        $parameter["pay_attach"]=$this->orderInfo['order_id'];
        $url='http://www.lianfapay.com/Pay_Index.html';
        $input='';
        foreach ($parameter as $key => $val){
            $input_item='<input type="hidden" name="' . $key . '" value="' . $val . '">';
            $input=$input.$input_item;
        }
        return "<p>正在跳转到支付页面...</p>
                <form class=\"form-inline\" method=\"post\" action=\"http://www.lianfapay.com/Pay_Index.html\">
                $input
                <button style=\"display:none\" id=\"pay\" type=\"submit\">pay</button>
            </form>
            <script>
                document.getElementById(\"pay\").click();
            </script>
                        ";
    }

    public function notifyUrl(Request $request)
    {
        $data = $request->all();
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['attach']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first()->toArray();
        $md5key = $payInfo['merchant_pem'];
        ksort($data);
        reset($data);
        $md5str = "";
        foreach ($data as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $md5key));
        if (!$data['transaction_id'] || $sign != $data['sign']) { //不合法的数据
            return 'fail';  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $this->successOrder($data['attach'], $data['transaction_id'], $data['amount']);
            return 'OK';
        }
    }
    
    public function post($url="" ,$requestData=array()){
                    
            $curl = curl_init();
    
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
           
            //普通数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestData));
            $res = curl_exec($curl);
    
            //$info = curl_getinfo($ch);
            curl_close($curl);
            return $res;
        }
    
}
