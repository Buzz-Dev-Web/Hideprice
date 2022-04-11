<?php

/**
 * @package   Buzz_Hideprice
 * @author    github.com/mauricio-tonny
 * @copyright Copyright (c)
 */

namespace Buzz\Hideprice\Pricing\Render;

use Magento\Catalog\Pricing\Price;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Pricing\Render\PriceBox as BasePriceBox;
use Magento\Msrp\Pricing\Price\MsrpPrice;
use Buzz\Hideprice\Helper\Data as Helper;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Http\Context;

/**
 * Class for final_price rendering
 *
 * @method bool getUseLinkForAsLowAs()
 * @method bool getDisplayMinimalPrice()
 */
class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    protected $_helper;

    private $customerSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Pricing\SaleableInterface $saleableItem,
        \Magento\Framework\Pricing\Price\PriceInterface $price,
        \Magento\Framework\Pricing\Render\RendererPool $rendererPool,
        array $data = [],
        \Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface $salableResolver = null,
        \Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface $minimalPriceCalculator = null,
        Helper $helper,
        CustomerSession $customerSession, 
        Context $httpContext
    ) {
        parent::__construct($context, 
                            $saleableItem, 
                            $price, 
                            $rendererPool, 
                            $data, 
                            $salableResolver, 
                            $minimalPriceCalculator);

        $this->_helper = $helper;
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
    }

    /**
     * Wrap with standard required container
     *
     * @param string $html
     * @return string
     */
    protected function wrapResult($html)
    {
        if($this->_helper->getIsEnable()){

            $wording = $this->_helper->getWordingHidePrice();
            
            if(!(bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)){
                return '<div class="price-box" ' .
                    'data-role="priceBox" ' .
                    'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                    '>'.$wording.'</div>';
            }
            
        }
            
        return '<div class="price-box ' . $this->getData('css_classes') . '" ' .
            'data-role="priceBox" ' .
            'data-product-id="' . $this->getSaleableItem()->getId() . '" ' .
            'data-price-box="product-id-' . $this->getSaleableItem()->getId() . '"' .
            '>' . $html . '</div>';
    }
}