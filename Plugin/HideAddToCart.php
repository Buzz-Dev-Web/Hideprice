<?php

namespace Buzz\Hideprice\Plugin;

use Buzz\Hideprice\Helper\Data;
use Magento\Catalog\Model\Product;

class HideAddToCart
{
    private $helperData;

    public function __construct(Data $helperData)
    {
        $this->helperData = $helperData;
    }

    public function afterIsSaleable(Product $product)
    {
        if($this->helperData->getIsEnable()){
            return [];
        }

        return $product;
    }

}