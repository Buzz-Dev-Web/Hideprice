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

class CollectionObserver implements ObserverInterface
{
    /**
     * @var \Buzz\Hideprice\Helper\Data
     */
    protected $helper;

    /**
     * @param ProductAvailableHelper $helper
     */
    public function __construct(
		ProductAvailableHelper $helper
    ) {
		$this->helper = $helper;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		if ($this->helper->hidePrice()) {
			$collection = $observer->getEvent()->getCollection();
			foreach ($collection as $product) {
				$product->setCanShowPrice(false);
			}
		}
    }
}