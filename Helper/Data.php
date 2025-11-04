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

/**
 * Buzz Hideprice Data helper
*/
class Data extends AbstractHelper
{
    /**
     * Hide Add To Cart Config Path
     */
    const XML_CONFIG_HIDE_ADD_TO_CART = 'buzz_hideprice/available/hide_add_to_cart';
	
    /**
     * Hide From Groups Config Path
     */
    const XML_CONFIG_HIDE_ADD_TO_CART_GROUPS = 'buzz_hideprice/available/hide_add_to_cart_groups';
	
    /**
     * Hide Price Config Path
     */
    const XML_CONFIG_HIDE_PRICE = 'buzz_hideprice/available/hide_price';
	
    /**
     * Hide From Groups Config Path
     */
    const XML_CONFIG_HIDE_PRICE_GROUPS = 'buzz_hideprice/available/hide_price_groups';
	
    /**
	 * Customer Session
	 *
     * @var \Magento\Customer\Model\Session
     */
    protected $_session;

    /**
     * Initialize Helper
	 *
     * @param Context $context
     * @param Session $session
     */
    public function __construct(
        Context $context,
        Session $session
    ) {
        $this->_session = $session;
		
        parent::__construct(
			$context
		);
    }

    /**
     * Check Whether The Customer Allows Add To Cart
     *
     * @return bool
     */
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
     * Check Whether The Customer Allows Price
     *
     * @return bool
     */
    public function isAvailablePrice()
    {
		if ($this->_getConfig(self::XML_CONFIG_HIDE_PRICE)) {
			return !in_array(
				$this->_session->getCustomerGroupId(), 
				explode(',', $this->_getConfig(self::XML_CONFIG_HIDE_PRICE_GROUPS))
			);	      
		}
		return true;
    }	 
	
    /**
     * Retrieve Store Configuration Data
     *
     * @param   string $path
     * @return  string|null
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }      
}