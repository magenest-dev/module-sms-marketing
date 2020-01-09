<?php
/**
 * Created by PhpStorm.
 * User: heomep
 * Date: 01/12/2016
 * Time: 07:55
 */

namespace Magenest\SmsMarketing\Model\Textmarketer;

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

    private $_host = 'http://api.textmarketer.co.uk/gateway/?';
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
        return $this->_scopeConfig->getValue('smsmarketing/textmarketer/enabled');
    }

    public function getTextmarketerUsername()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textmarketer/username');
    }

    /**
     * Getting TextmarketerSMS API Password
     * @return string
     */

    public function getTextmarketerPassword()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textmarketer/password');
    }


    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textmarketer/sender');
    }

    /**
     * @return mixed
     */
    public function getContentSMS()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textmarketer/content');
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->_scopeConfig->getValue('smsmarketing/textmarketer/number');
    }

    /**
     * Send SMS
     *
     * @param $code
     * @return array|mixed
     */

    public function sendSMS($code, $mobiNumber)
    {
        $username = $this->getTextmarketerUsername();

        $password = $this->getTextmarketerPassword();

        $sender = urlencode($this->getSender());


        $_host = $this->_host;

        $data = 'username='.urlencode($username).
            '&password='.urlencode($password).
            "&option=json".
            '&to='.urlencode($mobiNumber).
            '&message='.urlencode($code).
            '&orig='.urlencode($sender);

        $url = $_host.$data;

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
