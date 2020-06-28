<?php


namespace App\Services;

use App\Exceptions\AppException;

/**
 * 商品服务层.
 * Class ProductsService
 * @package App\Services
 */
class ProductsService
{

    /**
     * 格式化批发价，用于计算.
     * @param string $wholesalePriceArr 待格式化的批发价.
     * @return array 格式化后的批发价数组.
     */
    public function formatWholesalePrice(string $wholesalePriceArr) : array
    {
        $waitArr = explode(PHP_EOL, $wholesalePriceArr);
        $formatData = [];
        foreach ($waitArr as $key => $val) {
            if($val != ""){
                $explodeFormat = explode('=', delete_html($val));
                if (count($explodeFormat) != 2) throw new AppException("该商品批发价格式有误，请联系管理员");
                $formatData[$key]['number'] = $explodeFormat[0];
                $formatData[$key]['price'] = $explodeFormat[1];
            }
        }
        sort($formatData);
        return $formatData;
    }

    /**
     * 格式化代充输入框.
     * @param string $charge 待格式化内容.
     * @return array 格式化后的内容.
     * @throws AppException
     */
    public function formatChargeInput(string $charge) : array
    {
        $inputArr = explode(PHP_EOL, $charge);
        $formatData = [];
        foreach ($inputArr as $key => $val) {
            if($val != ""){
                $explodeFormat = explode('=', delete_html($val));
                if (count($explodeFormat) != 3) throw new AppException("代充输入框配置有误，请联系管理员");
                $formatData[$key]['field'] = $explodeFormat[0];
                $formatData[$key]['desc'] = $explodeFormat[1];
                $formatData[$key]['rule'] = filter_var($explodeFormat[2], FILTER_VALIDATE_BOOLEAN);
            }
        }
        return $formatData;
    }



}
