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
namespace Magenest\SmsMarketing\Model\Textlocal;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SendSms
 * @package Magenest\SmsMarketing\Model\Textlocal
 */
class SendSms
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * SendSms constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->_scopeConfig = $scopeConfig;
    }
    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textlocal/enabled');
    }
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textlocal/email');
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textlocal/hash');
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textlocal/sender');
    }

    /**
     * @return mixed
     */
    public function getContentSMS()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textlocal/content');
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textlocal/number');
    }

    /**
     * Send SMS
     *
     * @param $code
     * @return array|mixed
     */
    public function sendSMS($code, $mobiNumber)
    {
        $email = $this->getEmail();

        $hash = $this->getHash();

        $sender = urlencode($this->getSender());
        
        $message = rawurlencode($code);
        
        $data = array(
            'username' => $email,
            'hash' => $hash,
            'numbers' => $mobiNumber,
            'sender' => $sender,
            'message' => $message
        );

        // Send the POST request with cURL
        $ch = curl_init('http://api.txtlocal.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        
        return $data;
    }
}
