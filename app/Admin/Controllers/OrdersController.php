<?php

namespace App\Admin\Controllers;

use App\Models\Orders;
use App\Models\Products;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Jobs\SendMails;
use App\Models\Emailtpls;
use App\Models\Pays;
use Illuminate\Support\Facades\Redis;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Layout\Content;
class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */

    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Orders());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('order_id', __('Order id'))->copyable();
        $grid->column('ord_title', __('Ord title'));
        $grid->column('product.pd_name', __('Product id'));
        $grid->column('coupon.card', __('Coupon id'));
        $grid->column('ord_class', __('Ord class'))->using([1 => '自动发卡', 2 => '代充']);
        $grid->column('product_price', __('Product price'))->label('warning');
        $grid->column('buy_amount', __('Buy amount'))->label('info');
        $grid->column('ord_price', __('Ord price'))->label('success');
        $grid->column('account', __('Account'))->copyable();
        $grid->column('pay.pay_name', __('Pay way'));
        $grid->column('ord_status', __('Ord status'))->editable('select', [1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->disableCreateButton();
        $grid->filter(function ($filter) {
            // 范围过滤器，调用模型的`onlyTrashed`方法，查询出被软删除的数据。
            $filter->scope('trashed', '回收站')->onlyTrashed();
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->equal('order_id', '订单id');
            $filter->equal('account', '充值账号');
            $pdlisy = Products::get(['id', 'pd_name'])->toArray();
            $commod = [];
            foreach ($pdlisy as $val) {
                $commod[$val['id']] = $val['pd_name'];
            }
            $filter->equal('product_id', '所属商品')->select($commod);
            // 在这里添加字段过滤器
            $filter->equal('ord_status', '订单状态')->select([1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
            $filter->equal('ord_class', '订单类型')->select([1 => '卡密', 2 => '代充']);
            $filter->date('created_at', '订单日期');
        });
        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Orders());

        $form->display('order_id', __('Order id'));
        $form->display('ord_title', __('Ord title'));
        $form->display('product.pd_name', __('Product id'));
        $form->display('coupon.card', __('Coupon id'));
        $form->radio('ord_class', __('Ord class'))->options([1 => '自动发卡', 2 => '代充'])->disable();
        $form->display('product_price', __('Product price'))->default(0.00);
        $form->display('ord_price', __('Ord price'))->default(0.00);
        $form->display('buy_amount', __('Buy amount'));
        $form->textarea('search_pwd', __('Search pwd'))->disable();
        $form->textarea('account', __('Account'))->disable();
        $form->textarea('ord_info', __('Ord info'));
        $form->display('pay_ord', __('Pay ord'));
        $form->display('pay.pay_name', __('Pay way'));
        $form->ip('buy_ip', __('Buy ip'));
        $form->radio('ord_status', __('Ord status'))->options([1 => '待处理', 2 => '已处理', 3 => '已完成', 4 => '处理失败']);
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            $footer->disableCreatingCheck();
        });
        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });


        return $form;
    }
    
    public function pending_orders(Content $content)
    {
        $pendinglist=Redis::hgetall('PENDING_ORDERS_LIST');

            $headers = ['订单号', '商品名', '商品价格', '支付方式','发货方式','实际支付','邮箱','购买者ip','自定义输入'];
        $rows = [];
        foreach ($pendinglist as $k=>$v){
                $data=json_decode($v,true);
                if($data['pd_type']==1){
                    $type='自动发货';
                }else{
                    $type='代充';
                }
                $row = [$data['order_id'],$data['product_name'],$data['product_price'],Pays::where('id', $data['pay_way'])->get()->toArray()[0]['pay_name'],$type,$data['actual_price'],$data['account'],$data['buy_ip'],$data['other_ipu']];
                array_push($rows,$row);
                
            }
        $table = new Table($headers, $rows);
        $box = new Box('待支付订单', $table->render());
        return $content->body($box->render());
    }
}
