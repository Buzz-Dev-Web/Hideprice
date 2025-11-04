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
 * Salable Observer
 */
class SalableObserver implements ObserverInterface
{
    /**
     * ProductAvailable Helper
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
     * Handler For Product Salable Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
      if (!$this->_helper->isAvailableAddToCart()) {
        $salable = $observer->getEvent()->getSalable();		
        $salable->setIsSalable(false);			
      }
    }
} 