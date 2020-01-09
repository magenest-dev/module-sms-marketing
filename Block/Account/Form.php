<?php

namespace Magenest\SmsMarketing\Block\Account;

/**
 * Class Mobile
 * @package Magenest\SmsMarketing\Block\Account
 */
class Form extends \Magento\Framework\View\Element\Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getAction()
    {
        return $this->getUrl('smsmarketing/customer/check');
    }
}
