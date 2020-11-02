<?php

namespace App\Http\Controllers\Home;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Pages;

/**
 * 公共控制器.
 * Class HomeController
 * @package App\Http\Controllers\Home
 */
class HomeController extends Controller
{

    /**
     * 商品服务层.
     * @var
     */
    private $productService;

    /**
     * HomeController constructor.
     */
    public function __construct(ProductService $productsService)
    {
        $this->productService = $productsService;
    }

    /**
     * 首页
     * @param Request $request
     */
    public function index(Request $request)
    {
        $products = $this->productService->classAndProducts($request->all());
        return $this->view('static_pages/home', ['classifys' => $products]);
    }

    /**
     * 商品详情.
     * @param Products $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\AppException
     */
    public function buy(Products $product)
    {
        $info = $this->productService->productInfo($product);
        return $this->view('static_pages/buy', $info);
    }
    /**
     * 文章列表
     */
    public function pages(Pages $pages,Request $request)
    {
        $data = $request->all();
        if (isset($data['tpl'])) {
            $tpl=$data['tpl'];
        }else{
            $tpl= '';
        }
        $pages = Pages::where('status', 1)->get()->toArray();
        return $this->view('static_pages/pages', ['pages' => $pages],$tpl);
    }

    /**
     * 文章详情
     */
    public function page(Pages $pages, $tag,Request $request)
    {

        $page = Pages::where('tag', $tag)->get()->toArray();
        $data = $request->all();
        if (isset($data['tpl'])) {
            $tpl=$data['tpl'];
        }else{
            $tpl= '';
        }
        if (!$page) {
            throw new AppException(__('system.page_not_exit'));
        } else {
            $page = $page[0];
        }
        if ($page['status'] != 1) {
            throw new AppException(__('system.page_not_exit'));
        } else {
            return $this->view('static_pages/page', $page,$tpl);
        }
    }
}
