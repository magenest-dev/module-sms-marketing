<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SmsMarketing\Controller\Manage;

class Index extends \Magenest\SmsMarketing\Controller\Manage
{
    /**
     * Managing newsletter subscription page
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();

        if ($block = $this->_view->getLayout()->getBlock('customer_smsmarketing')) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        $this->_view->getPage()->getConfig()->getTitle()->set(__('SMS Marketing Subscription'));
        $this->_view->renderLayout();
    }
}
