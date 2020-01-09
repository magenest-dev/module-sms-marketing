<?php
/**
 * Created by Magenest
 * User: Luu Thanh Thuy
 * Date: 17/06/2016
 * Time: 14:53
 */

namespace Magenest\SmsMarketing\Observer\Layout;

use Magento\Customer\Model\Logger;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magenest\SmsMarketing\Helper\Data;

/**
 * Class Mobile
 * @package Magenest\SmsMarketing\Observer\Layout
 */
class Mobile implements ObserverInterface
{
    /**
     * @var \Magenest\SmsMarketing\Helper\Data
     */
    protected $helper;


    /**
     * @param Logger $logger
     * @param Data $helperData
     */
    public function __construct(
        Logger $logger,
        Data $helperData
    ) {
        $this->logger = $logger;
        $this->helper  = $helperData;
    }


    /**
     * Handler for 'customer_logout' event.
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /*
            * @var $request \Magento\Framework\App\Request\Http\Proxy
        */
        $request  = $this->helper->getRequest();
        $pathInfo = $request->getPathInfo();
        $is_allow = $this->helper->getIsEnableMobileInput();
        $is_login_allow = $this->helper->getIsEnableMobileLogin();

        if ($pathInfo == '/customer/account/create/') {
            if ($is_allow) {
                $observer->getEvent()->getLayout()->getUpdate()->addHandle('customer_account_create_mobile');
            }
        }
        if ($pathInfo == '/customer/account/login/') {
            if ($is_allow && $is_login_allow) {
                $observer->getEvent()->getLayout()->getUpdate()->addHandle('customer_account_login_mobile');
            }
        }
        if ($pathInfo == '/customer/account/edit/') {
            if ($is_allow) {
                $observer->getEvent()->getLayout()->getUpdate()->addHandle('customer_account_edit_mobile');
            }
        }
        if ($pathInfo == '/customer/account/') {
            if ($is_allow) {
                $observer->getEvent()->getLayout()->getUpdate()->addHandle('customer_account_index_mobile');
            }
        }
    }
}
