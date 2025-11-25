<?php

/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\View\Page\Config as PageConfig;

class AddBodyClassObserver implements ObserverInterface
{
    protected $httpContext;
    protected $pageConfig;

    public function __construct(
        HttpContext $httpContext,
        PageConfig $pageConfig
    ) {
        $this->httpContext = $httpContext;
        $this->pageConfig = $pageConfig;
    }

    public function execute(Observer $observer)
    {
        $isLoggedIn = (bool) $this->httpContext->getValue(CustomerContext::CONTEXT_AUTH);

        if ($isLoggedIn) {
            $this->pageConfig->addBodyClass('buzz-logged-in');
        } else {
            $this->pageConfig->addBodyClass('buzz-guest');
        }
    }
}
