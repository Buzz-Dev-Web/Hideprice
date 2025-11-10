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

/**
 * Plugin responsável por interceptar a renderização de preços
 * e exibir uma mensagem/link caso o cliente esteja deslogado.
 */
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

    /**
     * Intercepta o render de preços.
     * 
     * @param Render $subject
     * @param callable $proceed
     * @param mixed ...$args
     * @return string
     */
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
        if ($this->helper->isAvailablePrice()) {
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

        /**
         * Cria link de login com retorno para a página atual
         */
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
         * Retorna a mensagem com o link
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