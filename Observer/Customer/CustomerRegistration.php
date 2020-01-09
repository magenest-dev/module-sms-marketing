<?php
/**
 * Copyright © 2015 Magenest. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Magenest_SmsMarketing extension
 * NOTICE OF LICENSE
 *
 * @category Magenest
 * @package  Magenest_SmsMarketing
 * @author   CanhND
 */
namespace Magenest\SmsMarketing\Observer\Customer;

use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magenest\SmsMarketing\Model\Textlocal\SendSms as Textlocal;
use Magenest\SmsMarketing\Model\Nexmo\SendSms as Nexmo;
use Magenest\SmsMarketing\Model\Voodoo\SendSms as Voodoo;
use Magenest\SmsMarketing\Model\Textmarketer\SendSms as Textmarketer;
use Magenest\SmsMarketing\Model\Twilio\SendSms as Twilio;
use Magenest\SmsMarketing\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class CustomerRegistration
 * @package Magenest\SmsMarketing\Observer\Customer
 */
class CustomerRegistration implements ObserverInterface
{

    /**
     * @var \Magenest\SmsMarketing\Helper\Data
     */
    protected $helper;

    /**
     * @var Textlocal
     */
    protected $_textlocal;

    /**
     * @var Nexmo
     */
    protected $_nexmo;

    /**
     * @var Voodoo
     */
    protected $_voodoo;

    /**
     * @var Textmarketer
     */
    protected $_textmarketer;

    /**
     * @var Twilio
     */
    protected $_twilio;


    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @param Textlocal $textlocal
     * @param Data $helperData
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Textlocal $textlocal,
        Nexmo $nexmo,
        Voodoo $voodoo,
        Textmarketer $textmarketer,
        Twilio $twilio,
        Data $helperData
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_textlocal = $textlocal;
        $this->helper  = $helperData;
        $this->_nexmo = $nexmo;
        $this->_voodoo = $voodoo;
        $this->_textmarketer = $textmarketer;
        $this->_twilio = $twilio;
    }

    /**
     * Handler for 'customer_logout' event.
     *
     * @param  Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        $customer = $observer->getEvent()->getCustomer();
        $customerEmail = $customer->getEmail();
        $customerId = $customer->getId();
        $customerName = $customer->getFirstname();
        $mobile_number = $customer->getCustomAttribute('mobile_numbers')->getValue();
        if ($this->_scopeConfig->getValue('smsmarketing/content/enabled_register')) {
            $content = $this->_scopeConfig->getValue('smsmarketing/content/customer_register');
        }
        $replaceString = [
            '{{customer_name}}' => $customerName,
            '{{customer_email}}' => $customerEmail
        ];
        if ($mobile_number && isset($content)) {
            $newContent = strtr($content, $replaceString);
            if ($this->_nexmo->isEnabled()) {
                $this->_nexmo->sendSMS($newContent, $mobile_number);
            }
            if ($this->_textlocal->isEnabled()) {
                $this->_textlocal->sendSMS($newContent, $mobile_number);
            }
            if ($this->_voodoo->isEnabled()) {
                $this->_voodoo->sendSMS($newContent, $mobile_number);
            }
            if ($this->_textmarketer->isEnabled()) {
                $this->_textmarketer->sendSMS($newContent, $mobile_number);
            }
            if ($this->_twilio->isEnabled()) {
                $this->_twilio->sendSMS($newContent, $mobile_number);
            }
        }
    }
}
