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
namespace Magenest\SmsMarketing\Model\Nexmo;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SendSms
 * @package Magenest\SmsMarketing\Model\Nexmo
 */
class SendSms
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    protected $zendClientFactory;

    /**
     * SendSms constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\HTTP\ZendClientFactory $zendClientFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\ZendClientFactory $zendClientFactory
    ) {
    
        $this->_scopeConfig = $scopeConfig;
        $this->zendClientFactory = $zendClientFactory;
    }
    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->_scopeConfig->getValue('smsmarketing/nexmo/enabled');
    }
    
    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->_scopeConfig->getValue('smsmarketing/nexmo/api_key');
    }

    /**
     * @return mixed
     */
    public function getApiSecret()
    {
        return $this->_scopeConfig->getValue('smsmarketing/nexmo/api_secret');
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->_scopeConfig->getValue('smsmarketing/nexmo/sender');
    }

    /**
     * @return mixed
     */
    public function getContentSMS()
    {
        return $this->_scopeConfig->getValue('smsmarketing/nexmo/content');
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_scopeConfig->getValue('smsmarketing/nexmo/number');
    }

    /**
     * Send SMS
     *
     * @param $code
     * @return array|mixed
     */
    public function sendSMS($code, $mobiNumber)
    {
        $apiKey = $this->getApiKey();

        $apiSecret = $this->getApiSecret();

        $sender = urlencode($this->getSender());

        $client = $this->zendClientFactory->create();

        $url     = 'https://rest.nexmo.com/sms/json';

        $client->setUri($url);
        $client->setConfig([ 'timeout' => 300]);


        $client->setParameterGet('api_key', $apiKey);
        $client->setParameterGet('api_secret', $apiSecret);
        $client->setParameterGet('from', $sender);
        $client->setParameterGet('api_key', $apiKey);
        $client->setParameterGet('to', $mobiNumber);
        $client->setParameterGet('text', $code);


        $method   = \Zend_Http_Client::GET;
//        { Success:
//            "message-count": "1",
//    "messages": [{
//            "to": "84949684694",
//        "message-id": "0F0000004CFD11D4",
//        "status": "0",
//        "remaining-balance": "1.65490000",
//        "message-price": "0.04930000",
//        "network": "45202"
//    }]
//}
        $response = $client->request($method)->getBody();
        $data = json_decode($response, true);
        return $data;
    }
}
