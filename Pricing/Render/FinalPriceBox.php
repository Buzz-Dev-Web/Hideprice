<?php

/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Pricing\Render;

use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Buzz\Hideprice\Helper\Data as ProductAvailableHelper;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    /** @var \Magento\Framework\App\Http\Context */
    protected $httpContext;
    
    private ProductAvailableHelper $helper;

    /**
     * @param Context $context
     * @param SaleableInterface $saleableItem
     * @param PriceInterface $price
     * @param RendererPool $rendererPool
     * @param array $data
     * @param SalableResolverInterface $salableResolver
     * @param MinimalPriceCalculatorInterface $minimalPriceCalculator
     * @param \Magento\Framework\App\Helper\Context $httpContext
     */
    public function __construct(
        Context $context,
        SaleableInterface $saleableItem,
        PriceInterface $price,
        RendererPool $rendererPool,
        ProductAvailableHelper $helper,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = [],
        SalableResolverInterface $salableResolver = null,
        MinimalPriceCalculatorInterface $minimalPriceCalculator = null,
    ) {
        $this->httpContext = $httpContext;
        $this->helper = $helper;
        parent::__construct($context, $saleableItem, $price, $rendererPool, $data, $salableResolver, $minimalPriceCalculator);
    }

    protected function _toHtml()
    {
        if ($this->helper->hidePrice()) {
            $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    
            if (!$isLoggedIn) {
    
                $value = $this->_scopeConfig->getValue(
                    'buzz_hideprice/available/hide_price_text',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
    
                $currentUrl = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
    
                $loginUrl = $this->getUrl(
                    'customer/account/login',
                    ['referer' => base64_encode($currentUrl)]
                );
    
                if (!empty($value)) {
                    return sprintf(
                        '<a href="%s" class="buzz-hideprice-message">%s</a>',
                        $loginUrl,
                        $value
                    );
                }
            }
        }
    
        return parent::_toHtml();
    }    
}
