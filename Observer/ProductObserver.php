<?php

/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Buzz\Hideprice\Helper\Data as ProductAvailableHelper;

/**
 * Product Observer
 */
class ProductObserver implements ObserverInterface
{
    /**
     * Hideprice Helper
     *
     * @var \Buzz\Hideprice\Helper\Data
     */
    protected $_helper; 
	
    /**
     * Initialize Observer
     *
     * @param ProductAvailableHelper $helper
     */
    public function __construct(
		ProductAvailableHelper $helper
    ) {
		$this->_helper = $helper;
    }
	
    /**
     * Handler For Load Product Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
      if (!$this->_helper->isAvailablePrice()) {
        $product = $observer->getEvent()->getProduct();
        $product->setCanShowPrice(false);  
        
        
        // BUZZ | Customizacao Hide Price 
        $customMessage = __('Log in to see the price');
        $product->setCustomPriceMessage($customMessage);
      }
    }
} 