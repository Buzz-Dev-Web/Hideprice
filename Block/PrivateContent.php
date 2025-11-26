<?php

/**
* @package   Buzz_Hideprice
* @author    github.com/mauricio-tonny
* @copyright Copyright (c)
*/

namespace Buzz\Hideprice\Block;

use Magento\Framework\View\Element\Template;
use Buzz\Hideprice\Helper\Data;

class PrivateContent extends Template
{
    protected $helper;

    public function __construct(
        Template\Context $context,
        Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function getHelper()
    {
        return $this->helper;
    }
}
