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
use Magento\Framework\Exception\LocalizedException;

class QuoteObserver implements ObserverInterface
{
    /**
     * @var \Buzz\Hideprice\Helper\Data
     */
    protected $_helper;

    /**
     * @param ProductAvailableHelper $helper
     */
    public function __construct(
		ProductAvailableHelper $helper
    ) {
		$this->_helper = $helper;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		if ($this->_helper->hideAddToCart()) {
			throw new LocalizedException(
				__('You can not add products to cart.')
			);
		}
    }
}