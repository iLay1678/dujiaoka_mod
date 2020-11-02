<?php
namespace App\Http\Controllers\Pay;

use App\Exceptions\AppException;
use App\Models\Pays;
use Illuminate\Http\Request;
use Xhat\Payjs\Facades\Payjs;
use Illuminate\Support\Facades\Redis;

class PayjsController extends PayController
{

    public function gateway($payway, $oid)
    {
        $this->checkOrder($payway, $oid);
        // 构造订单基础信息
        $data = [
            'body' => '在线支付 - '. $this->orderInfo['product_name'],                                // 订单标题
            'total_fee' => (float)$this->orderInfo['actual_price'] * 100,                                   // 订单金额
            'out_trade_no' => $this->orderInfo['order_id'],                           // 订单号
            'notify_url' => site_url().$this->payInfo['pay_handleroute'].'/notify_url',
            'logo' => 'https://www.ifking.cn/favicon.png' //LOGO
        ];
        config(['payjs.mchid' => $this->payInfo['merchant_id'], 'payjs.key' => $this->payInfo['merchant_pem']]);
        switch ($this->payInfo['pay_check']){
            case 'payjswescan':
                try{
                    $url =  Payjs::cashier($data);
                    $result['payname'] = $this->payInfo['pay_name'];
                    $result['actual_price'] = $this->orderInfo['actual_price'];
                    $result['orderid'] = $this->orderInfo['order_id'];
                    $result['qr_code'] = $url;
                    return $this->view('static_pages/qrpay', $result);
                } catch (\Exception $e) {
                    throw new AppException('支付通道异常~ '.$e->getMessage());
                }
                break;
        }
    }

    public function notifyUrl(Request $request)
    {
        $oid = $request->post('out_trade_no');
        $cacheord = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        if (!$cacheord) {
            return 'error';
        }
        $payInfo = Pays::query()->where('id', $cacheord['pay_way'])->first();
        config(['payjs.mchid' => $payInfo['merchant_id'], 'payjs.key' => $payInfo['merchant_pem']]);
        $notify_info = Payjs::notify();
        $this->orderService->successOrder($notify_info['out_trade_no'], $notify_info['payjs_order_id'], $notify_info['total_fee'] / 100);
        return 'success';
    }

}
