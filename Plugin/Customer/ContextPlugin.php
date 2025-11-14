<?php

/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Plugin\Customer;

use Magento\Framework\App\Http\Context;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Customer\Model\Session;
use Psr\Log\LoggerInterface;

/**
 * Garante que caches e blocos variem conforme o estado de login do cliente.
 */
class ContextPlugin
{
    protected $session;
    protected $logger;

    public function __construct(Session $session, LoggerInterface $logger)
    {
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * Adiciona o estado do login ao contexto HTTP (para FPC e full_page cache)
     */
    public function beforeGetVaryString(Context $subject)
    {
        $isLoggedIn = (int) $this->session->isLoggedIn();

        $subject->setValue(
            CustomerContext::CONTEXT_AUTH,
            $isLoggedIn,
            0
        );

        return null;
    }

    /**
     * Adiciona o estado do login à chave de cache dos blocos HTML.
     */
    public function afterGetCacheKeyInfo($subject, $result)
    {
        try {
            if (is_array($result)) {
                $result['customer_logged_in'] = (int) $this->session->isLoggedIn();
            }
        } catch (\Exception $e) {
            $this->logger->error('Buzz_Hideprice cache variation error: ' . $e->getMessage());
        }

        return $result;
    }
}