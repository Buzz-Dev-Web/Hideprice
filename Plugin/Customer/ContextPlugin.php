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

/**
 * Garante que caches sejam diferentes para logado e visitante.
 */
class ContextPlugin
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

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
}
