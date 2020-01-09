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
namespace Magenest\SmsMarketing\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magenest\SmsMarketing\Model\Textlocal\SendSms as Textlocal;
use Magenest\SmsMarketing\Model\Voodoo\SendSms as Voodoo;
use Magenest\SmsMarketing\Model\Nexmo\SendSms as Nexmo;
use Magenest\SmsMarketing\Model\Textmarketer\SendSms as Textmarketer;
use Magenest\SmsMarketing\Model\Twilio\SendSms as Twilio;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Check
 *
 * @package Magenest\SmsMarketing\Controller\Adminhtml\System\Config
 */
class Check extends Action
{
    /**
     * @var /Magenest/ZohoCrm/Model/Connector
     */
    protected $_connector;

    /**
     * @var Textlocal
     */
    protected $_textlocal;

    protected $_voodoo;

    protected $_textmarketer;

    protected $_nexmo;

    protected $_twilio;
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @param Context $context
     * @param Textlocal $textlocal
     */
    public function __construct(
        Context $context,
        Textlocal $textlocal,
        Voodoo $voodoo,
        Nexmo $nexmo,
        Textmarketer $textmarketer,
        Twilio $twilio,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->_textlocal = $textlocal;
        $this->_voodoo = $voodoo;
        $this->_nexmo = $nexmo;
        $this->_textmarketer = $textmarketer;
        $this->_twilio = $twilio;
        $this->resultJsonFactory = $jsonFactory;
    }

    /**
     * Check whether vat is valid
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();

        $data = $this->getRequest()->getPostValue();

        $logger = $this->_objectManager->create('\Psr\Log\LoggerInterface');
        $logger->debug(print_r($data, true));

        $status = 'connect success';

        if ($data['number']) {
            if ($this->_nexmo->isEnabled()) {
                $response = $this->_nexmo->sendSMS($status, $data['number']);

                $logger = $this->_objectManager->create('\Psr\Log\LoggerInterface');
                $logger->debug(print_r($response, true));

                if ($response['messages'][0]['status'] == '0') {
                    $result['error'] = 0;
                    $result['description'] = 'Connected success';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                } else {
                    $result['error'] = 1;
                    $result['description'] = 'Invalid username or password';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                }
            }
            if ($this->_textlocal->isEnabled()) {
                $response = $this->_textlocal->sendSMS($status, $data['number']);

                $logger = $this->_objectManager->create('\Psr\Log\LoggerInterface');
                $logger->debug(print_r($response, true));

                if ($response['status'] == 'success') {
                    $result['error'] = 0;
                    $result['description'] = 'Connected success';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                } else {
                    $result['error'] = 1;
                    $result['description'] = 'Invalid username or password';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                }
            }
            if ($this->_voodoo->isEnabled()) {
                $response = $this->_voodoo->sendSMS($status, $data['number']);

                $logger = $this->_objectManager->create('\Psr\Log\LoggerInterface');
                $logger->debug(print_r($response, true));

                if ($response['resultText'] == '200 OK') {
                    $result['error'] = 0;
                    $result['description'] = 'Connected success';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                } else {
                    $result['error'] = 1;
                    $result['description'] = 'Invalid username or password';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                }
            }

            if ($this->_textmarketer->isEnabled()) {
                $response = $this->_textmarketer->sendSMS($status, $data['number']);

                $logger = $this->_objectManager->create('\Psr\Log\LoggerInterface');
                $logger->debug(print_r($response, true));

                if ($response['status'] == 'success') {
                    $result['error'] = 0;
                    $result['description'] = 'Connected success';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                } else {
                    $result['error'] = 1;
                    $result['description'] = 'Invalid username or password';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                }
            }
            if ($this->_twilio->isEnabled()) {
                $response = $this->_twilio->sendSMS($status, $data['number']);

                $logger = $this->_objectManager->create('\Psr\Log\LoggerInterface');
                $logger->debug(print_r($response, true));

                if ($response['status'] == 'queued') {
                    $result['error'] = 0;
                    $result['description'] = 'Connected success';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                } else {
                    $result['error'] = 1;
                    $result['description'] = 'Invalid username or password';

                    $resultJson->setData(json_encode($result));
                    return $resultJson;
                }
            }
        }
    }
}
