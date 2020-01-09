<?php
/**
 * Created by PhpStorm.
 * User: heomep
 * Date: 30/11/2016
 * Time: 17:25
 */
namespace Magenest\SmsMarketing\Model\Voodoo;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SendSms
 * @package Magenest\SmsMarketing\Model\Voodoo
 */
class SendSms
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    protected $_platform = 'Magento';
    /**
     * The version of e-commerce platform
     * @var string
     */
    protected $_platformVersion = '2.0';
    /**
     * Return type of api method
     * @var string
     */
    protected $_format = 'json';
    /**
     * To be used by the API
     * @var string
     */
    protected $_host = 'https://www.voodoosms.com/';

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
        return $this->_scopeConfig->getValue('smsmarketing/voodoo/enabled');
    }

    public function getVoodooApiUsername()
    {
        return $this->_scopeConfig->getValue('smsmarketing/voodoo/username');
    }

    /**
     * Getting VoodooSMS API Password
     * @return string
     */

    public function getVoodooApiPassword()
    {
        return $this->_scopeConfig->getValue('smsmarketing/voodoo/password');
    }


    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->_scopeConfig->getValue('smsmarketing/voodoo/sender');
    }

    /**
     * @return mixed
     */
    public function getContentSMS()
    {
        return $this->_scopeConfig->getValue('smsmarketing/voodoo/content');
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_scopeConfig->getValue('smsmarketing/voodoo/number');
    }

    /**
     * Send SMS
     *
     * @param $code
     * @return array|mixed
     */


//    public function curl($url)
//    {
//
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_URL, $url);
//        $response = curl_exec($ch);
//        curl_close($ch);
//        $data = json_decode($response, true);
//
//        return $data;
////        return file_get_contents($url);
//    }

    public function sendSMS($code, $mobiNumber)
    {
        $username = $this->getVoodooApiUsername();

        $password = $this->getVoodooApiPassword();

        $sender = urlencode($this->getSender());


        $_host = $this->_host;
        $path = 'vapi/server/sendSMS?';
        $data = 'uid='.urlencode($username).
            '&pass='.urlencode($password).
            '&dest='.urlencode($mobiNumber).
            '&orig='.urlencode($sender).
            '&msg='.urlencode($code).
            '&validity=1';
        $_format = '&format='.$this->_format;
        $_platform ='&platform='.$this->_platform.'&platform_version='.$this->_platformVersion;
        $url = $_host.$path.$data.$_format.$_platform;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        return $data;
    }
}
