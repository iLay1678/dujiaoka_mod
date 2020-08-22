<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class OrdersController extends Controller
{

    /**
     * 查询订单首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrder(Request $request)
    {
        $data = $request->all();
        if (isset($data['tpl'])) {
            $tpl=$data['tpl'];
        }else{
           $tpl= '';
        }
        return $this->view('static_pages/searchOrder',[],$tpl);
    }

    /**
     * 获取订单支付状态
     */
    public function getOrderStatus($oid)
    {
        $orderInfo = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        $isSuccess = Redis::hget('ORDERS_SUCCESS_LIST', $oid);
        if (!$orderInfo && !$isSuccess) {
            return response()->json(['msg' => '订单已过期', 'code' => 400001]);
        }
        if (!$isSuccess) {
            return response()->json(['msg' => '等待支付', 'code' => 400000]);
        }
        return response()->json(['msg' => '支付成功', 'code' => 200, 'oid' => $oid]);
    }

    /**
     * 通过订单号查询
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrderById($oid = "",Request $request)
    {
        $data = $request->only(['tpl']);
        if (isset($data['tpl'])) {
            $tpl=$data['tpl'];
        }else{
           $tpl= '';
        }
        $orderId =  \request()->input('order_id') ? \request()->input('order_id') : $oid;
        $order = Orders::where('order_id', $orderId)->get();
        if (empty($orderId) || $order->isEmpty()) throw new AppException('订单信息不存在！');
        return $this->view('static_pages/orderinfo', ['orders' => $order],$tpl);
    }

    /**
     *根据账户信息查询
     */
    public function searchOrderByAccount(Request $request)
    {

        $data = $request->only(['account', 'search_pwd','tpl']);
        $data['search_pwd'] = $data['search_pwd'] ?? 'dujiaoka';
        if (isset($data['tpl'])) {
            $tpl=$data['tpl'];
        }else{
           $tpl= '';
        }
        if (empty($data['account']) || (config('webset.isopen_searchpwd') == 1 && empty($data['search_pwd']))) throw new AppException(__('prompt.required_fields_cannot_be_empty'));
        $orders = Orders::where(['account' => $data['account'], 'search_pwd' => $data['search_pwd']])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        if (empty($orders)) throw new AppException('未找到相关订单！');
        return $this->view('static_pages/orderinfo', ['orders' => $orders],$tpl);
    }

    /**
     * 根据浏览器缓存查询订单
     */
    public function searchOrderByBrowser(Request $request)
    {
        $data = $request->only(['tpl']);
        if (isset($data['tpl'])) {
            $tpl=$data['tpl'];
        }else{
           $tpl= '';
        }
        $cookies = Cookie::get('orders');
        if (empty($cookies)) throw new AppException('未找到相关订单缓存');
        $orderIds = json_decode($cookies, true);
        $orders = Orders::whereIn('order_id', $orderIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->toArray();
        if (empty($orders)) throw new AppException('未找到相关订单！');
        return $this->view('static_pages/orderinfo', ['orders' => $orders],$tpl);

    }


}
