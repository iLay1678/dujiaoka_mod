<?php

Route::group(['middleware' => ['switch.language'], 'namespace' => 'Home'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('buy/{product}', 'HomeController@buy');
    Route::get('bill/{orderid}', 'OrderController@bill');
    Route::post('postOrder', 'OrderController@createOrder');
    Route::get('getOrderStatus/{orderid}', 'OrdersController@getOrderStatus');
    Route::get('searchOrder', 'OrdersController@searchOrder');
    Route::match(['get', 'post'], 'searchOrderById/{oid?}', 'OrdersController@searchOrderById');
    Route::post('searchOrderByAccount', 'OrdersController@searchOrderByAccount');
    Route::get('searchOrderByBrowser', 'OrdersController@searchOrderByBrowser');
    Route::get('pages', 'HomeController@pages');
    Route::get('pages/{tag}.html', 'HomeController@page');
});

//api相关
Route::group(['prefix' => 'api'], function () {
    Route::get('typelist', 'ApiController@typelist');
    Route::post('productlist', 'ApiController@productlist');
    Route::post('proudctinfo', 'ApiController@proudctinfo');
    Route::get('payways', 'ApiController@payways');
    Route::match(['get', 'post'], 'searchOrderById/{oid?}', 'ApiController@searchOrderById');
    Route::post('searchOrderByAccount', 'ApiController@searchOrderByAccount');
    Route::get('searchOrderByBrowser', 'ApiController@searchOrderByBrowser');
    Route::post('postOrder', 'ApiController@postOrder');
});
