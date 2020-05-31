<?php
namespace App\Http\Controllers\Pay;

use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class KingController extends PayController
{
    public function fubei($payway, $oid)
    {
        $check = $this->checkOrder($payway, $oid);
        if ($check !== true) {
            return $this->error($check);
        }
        //构造要请求的参数数组，无需改动
     
        switch ($this->payInfo['pay_check']) {
            case 'aliqr':
                $data = ["app_id" => '20181226104750540837', "method" => "openapi.payment.order.scan", "format" => "json", "sign_method" => "md5", "nonce" => "ilay1380"];
                $content = ["type" => 2, "merchant_order_sn" => date('YmdHis').rand(1,65535), "body" => $this->orderInfo['product_name'], "total_fee" => $this->orderInfo['actual_price'], "store_id" => '699083', 'call_back_url' => site_url() . $this->payInfo['pay_handleroute'] . '/notify_url', "attach" => $this->orderInfo['order_id']];
                $data['biz_content'] = json_encode($content);
                try {
                    $res = $this->execute($data, 'ab228f94d1518c7c6087a75aa8d65d51');
                    $qrcode = json_decode($res, true)['data']['qr_code'];
                    $result['qr_code'] = $qrcode;
                    $result['payname'] = $this->payInfo['pay_name'].'] [请勿刷新本页面';
                    $result['actual_price'] = $this->orderInfo['actual_price'];
                    $result['orderid'] = $this->orderInfo['order_id'];
                    $result['jump_payuri'] = $result['qr_code'];
                    return $this->view('static_pages/qrpay', $result);
                } catch (\Exception $e) {
                    return $this->error('请重新下单');
                }
                break;
            case 'wechat':
            		$data=file_get_contents('https://tools.ifking.cn/fubei/wechat.php?order_no='.$this->orderInfo['order_id'].'&price='.$this->orderInfo['actual_price'].'&info='.$this->orderInfo['product_name'].'&notify_url='.site_url() . $this->payInfo['pay_handleroute'] . '/notify_url');
                	$result['qr_code'] = json_decode($data,true)['url'];
                    $result['payname'] = $this->payInfo['pay_name'];
                    $result['actual_price'] = $this->orderInfo['actual_price'];
                    $result['orderid'] = $this->orderInfo['order_id'];
                    $result['jump_payuri'] = $result['qr_code'];
                    return $this->view('static_pages/qrpay', $result);
                break;
            default:
                $parameter['type'] = 3;
                break;
        }
        $quri = mzf_md5_signquery($parameter, $this->payInfo['merchant_pem']);
        $payurl = self::PAY_URI . $quri;
        //支付页面
        return redirect()->away($payurl);
    }
    public function fubeinotify(Request $request)
    {
        $post = $request->post();
        $data = json_decode($post['data'], true);
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['attach']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $sign = $post['sign'];
        unset($post['sign']);
        $signstr = "";
        ksort($post);
        foreach ($post as $key => $val) {
            if (!empty($val)) {
                $signstr .= $key . "=" . $val . "&";
            }
        }
        $signstr = rtrim($signstr, "&") . 'ab228f94d1518c7c6087a75aa8d65d51';
        $signs = strtoupper(md5($signstr, FALSE));
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first();
        if (!$data['trade_no'] || $sign != $signs) {
            //不合法的数据
            return 'fail';
            //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->successOrder($data['attach'], $data['platform_order_no'], $data['total_fee']);
            return 'success';
        }
    }
    public function mugglepay($payway, $oid)
    {
        $check = $this->checkOrder($payway, $oid);
        if ($check !== true) {
            return $this->error($check);
        }
        //构造要请求的参数数组，无需改动
        switch ($this->payInfo['pay_check']) {
            case 'coin':
            default:
                try {
                    $arr['price_amount'] =  $this->orderInfo['actual_price'];
                    $arr['price_currency'] = 'CNY';
                    $arr['merchant_order_id'] = $this->orderInfo['order_id'];
                    $arr['title'] =  "水一方杂货铺";
                    $arr['description'] =  $this->orderInfo['product_name'];
                    $arr['token'] =md5($this->orderInfo['order_id']. 'CNY'.$this->payInfo['merchant_id']);
                    $arr['callback_url']=site_url() . $this->payInfo['pay_handleroute'] . '/notify_url';
                    $arr['cancel_url']=site_url();
                    $arr['success_url']=site_url()  . 'searchOrderById/'.$this->orderInfo['order_id'];
                    $accesstoken=$this->payInfo['merchant_id'];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(CURLOPT_URL => "https://api.mugglepay.com/v1/orders", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => http_build_query($arr), CURLOPT_HTTPHEADER => array("token:$accesstoken", "Content-Type: application/x-www-form-urlencoded")));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $payment_url = json_decode($response, true)['payment_url'];
                     return redirect()->away($payment_url);
                } catch (\Exception $e) {
                    return $this->error('支付通道异常~ ' . $e->getMessage());
                }
                break;
        }
       
    }
    public function mugglepaynotify(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'),true);
       
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $data['merchant_order_id']), true);
        if (!$cacheord) {
            return 'fail';
        }
        $payInfo = Pays::where('id', $cacheord['pay_way'])->first();
        if (!$data['token'] || $data['token'] != md5($data['merchant_order_id']. 'CNY'.$payInfo['merchant_id'])) {
            //不合法的数据
            return 'fail';
            //返回失败 继续补单
        } else {
            //合法的数据
            //业务处理
            $this->successOrder($data['merchant_order_id'], $data['order_id'], $data['pay_amount']);
            return "{\"status\": 200}";
        }
    }
    const GATEWAY = "https://shq-api.51fubei.com/gateway";
    public static function execute($content, $key)
    {
        $content['sign'] = static::generateSign($content, $key);
        $result = static::mycurl(static::GATEWAY, $content);
        return $result;
    }
    private static function mycurl($url, $params = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLS_ECDHE_RSA_WITH_AES_128_GCM_SHA256');
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        $header = array("content-type: application/json");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $reponse = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($reponse, $httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }
    private static function generateSign($content, $key)
    {
        return strtoupper(static::sign(static::getSignContent($content) . $key));
    }
    private static function getSignContent($content)
    {
        ksort($content);
        $signString = "";
        foreach ($content as $key => $val) {
            if (!empty($val)) {
                $signString .= $key . "=" . $val . "&";
            }
        }
        $signString = rtrim($signString, "&");
        return $signString;
    }
    private static function sign($data)
    {
        return md5($data);
    }
}