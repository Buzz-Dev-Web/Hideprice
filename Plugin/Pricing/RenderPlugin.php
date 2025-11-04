<?php


/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Plugin\Pricing;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Pricing\Render;
use Magento\Catalog\Model\Product;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Buzz\Hideprice\Helper\Data as HideHelper;
use Psr\Log\LoggerInterface;

class RenderPlugin
{
    protected $helper;
    protected $logger;
    protected $request;
    protected static $shownInProductPage = false;

    public function __construct(
        HideHelper $helper,
        LoggerInterface $logger,
        RequestInterface $request
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->request = $request;
    }

    public function aroundRender(Render $subject, callable $proceed, ...$args)
    {
        $subject->setCacheLifetime(null);

        $item = $subject->getSaleableItem();
        $zone = $subject->getZone() ?: Render::ZONE_ITEM_VIEW;

        $product = null;
        if ($item instanceof QuoteItem) {
            $product = $item->getProduct();
        } elseif ($item instanceof Product) {
            $product = $item;
        }

        if ($this->helper->isAvailablePrice()) {
            return $proceed(...$args);
        }

        $isProductPage = $this->request->getFullActionName() === 'catalog_product_view';

        /**
         * 
         * Exibe uma vez na página do produto para evitar duplicidade
         * 
         */
        if ($isProductPage) {
            if (self::$shownInProductPage) {
                return '';
            }
            self::$shownInProductPage = true;
        }

        try {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $urlBuilder = $objectManager->get(\Magento\Framework\UrlInterface::class);
            $currentUrl = $urlBuilder->getCurrentUrl();
            $loginUrl = $urlBuilder->getUrl('customer/account/login', [
                'referer' => base64_encode($currentUrl)
            ]);
        } catch (\Exception $e) {
            $loginUrl = '/customer/account/login/';
        }

        /**
         * 
         * Exibe o botão se cliente deslogado
         * 
         */
        return sprintf(
            '<a href="%s" class="buzz-hideprice-link">
                <div class="buzz-hideprice-message">%s</div>
            </a>',
            $loginUrl,
            __('Log in to see the price.')
        );
    }
}
