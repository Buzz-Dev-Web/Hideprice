<?php

/**
 * @package   Buzz_Hideprice
 * @author    github.com/mauricio-tonny
 * @copyright Copyright (c)
 */

namespace Buzz\Hideprice\Plugin;

use Buzz\Hideprice\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Http\Context;

class HideAddToCart
{
    private $helperData;

    private $customerSession;
    private $httpContext;

    public function __construct(Data $helperData, CustomerSession $customerSession, Context $httpContext)
    {
        $this->helperData = $helperData;
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
        
    }

    public function afterIsSaleable(Product $product, $result)
    {
        if($result){
            if($this->helperData->getIsEnable()){
                return((bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH));                
            }
            return true;
        }

        return false;
    }

}