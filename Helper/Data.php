<?php

/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;

class Data extends AbstractHelper
{
    const XML_CONFIG_HIDE_ADD_TO_CART = 'buzz_hideprice/available/hide_add_to_cart';
    const XML_CONFIG_HIDE_ADD_TO_CART_GROUPS = 'buzz_hideprice/available/hide_add_to_cart_groups';
    const XML_CONFIG_HIDE_PRICE = 'buzz_hideprice/available/hide_price';
    const XML_CONFIG_HIDE_PRICE_GROUPS = 'buzz_hideprice/available/hide_price_groups';

    protected $_session;
    protected $httpContext;

    public function __construct(
        Context $context,
        Session $session,
        HttpContext $httpContext
    ) {
        $this->_session = $session;
        $this->httpContext = $httpContext;
        parent::__construct($context);
    }

    public function isAvailableAddToCart()
    {
        if ($this->_getConfig(self::XML_CONFIG_HIDE_ADD_TO_CART)) {
            return !in_array(
                $this->_session->getCustomerGroupId(),
                explode(',', $this->_getConfig(self::XML_CONFIG_HIDE_ADD_TO_CART_GROUPS))
            );
        }
        return true;
    }

    /**
     * Check whether the customer can see prices
     */
    public function isAvailablePrice()
    {
        if (!(bool)$this->_getConfig(self::XML_CONFIG_HIDE_PRICE)) {
            return true;
        }
    
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    
        if (!$isLoggedIn) {
            return false;
        }
    
        $hiddenGroups = explode(',', (string)$this->_getConfig(self::XML_CONFIG_HIDE_PRICE_GROUPS));
        if (in_array($this->_session->getCustomerGroupId(), $hiddenGroups)) {
            return false;
        }
    
        return true;
    }

    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }
}
