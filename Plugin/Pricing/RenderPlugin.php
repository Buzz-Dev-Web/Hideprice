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
use Magento\Customer\Model\Session as CustomerSession;
use Psr\Log\LoggerInterface;

class RenderPlugin
{
    protected $helper;
    protected $logger;
    protected $request;
    protected $customerSession;
    protected static $shownInProductPage = false;

    public function __construct(
        HideHelper $helper,
        LoggerInterface $logger,
        RequestInterface $request,
        CustomerSession $customerSession
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->request = $request;
        $this->customerSession = $customerSession;
    }

    public function aroundRender(Render $subject, callable $proceed, ...$args)
    {
        /**
         * Desabilita cache para este bloco — 
         * garante que o preço ou mensagem sejam sempre gerados
         * de acordo com o contexto (logado / deslogado).
         */
        $subject->setCacheLifetime(null);

        $item = $subject->getSaleableItem();
        $zone = $subject->getZone() ?: Render::ZONE_ITEM_VIEW;

        $product = null;
        if ($item instanceof QuoteItem) {
            $product = $item->getProduct();
        } elseif ($item instanceof Product) {
            $product = $item;
        }

        /**
         * Se o cliente pode ver o preço (config ou grupo), mostra normalmente
         */
        $isLoggedIn = $this->customerSession->isLoggedIn();
        $isAvailable = $this->helper->isAvailablePrice();

        $this->logger->debug(sprintf(
            'Buzz_Hideprice: RenderPlugin - Logado=%s, HelperAvailable=%s, ProdutoID=%s',
            $isLoggedIn ? 'sim' : 'não',
            $isAvailable ? 'sim' : 'não',
            $product ? $product->getId() : 'N/A'
        ));

        if ($isLoggedIn || $isAvailable) {
            return $proceed(...$args);
        }

        /**
         * Cliente deslogado — exibe apenas a mensagem de login
         * 
         * Evita duplicidade na página do produto.
         */
        $isProductPage = $this->request->getFullActionName() === 'catalog_product_view';
        if ($isProductPage && self::$shownInProductPage) {
            return '';
        }
        if ($isProductPage) {
            self::$shownInProductPage = true;
        }

        // Cria link de login com retorno para a página atual
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
         * Retorna a mensagem com o link e oculta o estoque
         */
        $cssHide = '<style>
            .price-box, .price, .old-price, .special-price, .stock, .availability {
                display: none !important;
            }
        </style>';

        $message = '<a href="' . $loginUrl . '" class="buzz-hideprice-link">
            <div class="buzz-hideprice-message">' . __('Faça login para ver o preço.') . '</div>
        </a>';

        return $cssHide . $message;
    }
}