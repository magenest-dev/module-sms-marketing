<?php
/**
 * Created by PhpStorm.
 * User: heomep
 * Date: 04/12/2016
 * Time: 09:00
 */
namespace Magenest\SmsMarketing\Model\Twilio;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SendSms
 * @package Magenest\SmsMarketing\Model\Textmarketer
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
     * @param \Magento\Framework\HTTP\ZendClientFactory $zendClientFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
    
        $this->_scopeConfig = $scopeConfig;
    }
    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/enabled');
    }

    public function getTwilioId()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/sid');
    }

    /**
     * Getting TextmarketerSMS API Password
     * @return string
     */

    public function getTwilioToken()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/token');
    }

    public function getTwilioPhoneNumber()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/from');
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/sender');
    }

    /**
     * @return mixed
     */
    public function getContentSMS()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/content');
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_scopeConfig->getValue('smsmarketing/twilio/number');
    }


    public function sendSMS($code, $mobiNumber)
    {
        $sid = urlencode($this->getTwilioId());

        $token = urlencode($this->getTwilioToken());

        $from = $this->getTwilioPhoneNumber();

        $uri = 'https://api.twilio.com/2010-04-01/Accounts/' . $sid . '/Messages.json?';

        $data =
            '&To=+'.urlencode($mobiNumber).
            '&From=+'.urlencode($from).
            '&Body='.urlencode($code);



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $sid . ':' . $token);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return $data;
    }
}
