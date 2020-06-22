@extends('layui.layouts.default')
@section('content')
<script>
    document.title = '订单查询 - '+document.title;  
</script>
    <div class="layui-row">
        <div class="layui-container">

            <div class="layui-card cardcon">
                <div class="layui-card-header">查询订单</div>

                <div class="layui-card-body ">
                    <!--<blockquote class="layui-elem-quote">
				友情提示:订单查询最多仅能查询到最近五笔订单。
			        </blockquote>-->
                    <div class="layui-tab layui-tab-brief">
                        <ul class="layui-tab-title">
                            <li class="layui-this">订单号</li>
                            <li>邮箱</li>
                            <li>浏览器缓存</li>
                        </ul>
                        <div class="layui-tab-content">
                            <!-- 订单号查询 -->
                            <div class="layui-tab-item layui-show">
                                <form class="layui-form" action="{{ url('searchOrderById') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">订单编号</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="order_id" required  lay-verify="required" placeholder="请输入订单编号" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderByid">立即查询</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <!-- 邮箱查询 -->
                            <div class="layui-tab-item">
                                <form class="layui-form" action="{{ url('searchOrderByAccount') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">邮箱</label>
                                        <div class="layui-input-inline">
                                            <input type="email" name="account" required  lay-verify="required" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">查询密码</label>
                                        <div class="layui-input-inline">
                                            <input type="password" name="search_pwd" required  lay-verify="required" placeholder="请输入查询密码" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="orderByAccount">立即查询</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- 浏览器缓存 -->
                            <div class="layui-tab-item">
                                <form class="layui-form" action="{{ url('searchOrderByBrowser') }}">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <div class="layui-input-block">
                                            <button class="layui-btn" lay-submit lay-filter="searchOrderByBrowser">立即查询</button>
                                        </div>
                                    </div>
                                </form>


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
        layui.use(['element', 'form'], function(){
            var element = layui.element;
            var form = layui.form;
            //监听提交
            form.on('submit(orderByid)', function(data){
                return true;
            });
            //监听提交
            form.on('submit(orderByAccount)', function(data){
                return true;
            });
            //监听提交
            form.on('submit(searchOrderByBrowser)', function(data){
                return true;
            });
        });
    </script>
@stop
