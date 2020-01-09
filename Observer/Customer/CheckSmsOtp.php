<?php

namespace Magenest\SmsMarketing\Observer\Customer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magenest\SmsMarketing\Model\Textlocal\SendSms as Textlocal;
use Magenest\SmsMarketing\Model\Nexmo\SendSms as Nexmo;
use Magenest\SmsMarketing\Model\Voodoo\SendSms as Voodoo;
use Magenest\SmsMarketing\Model\Textmarketer\SendSms as Textmarketer;
use Magenest\SmsMarketing\Model\Twilio\SendSms as Twilio;

class CheckSmsOtp implements ObserverInterface
{
    /**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;

    /**
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlManager;


    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;
    protected $http;
    protected $responseFactory;
    protected $scopeConfig;
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
     * CheckSmsOtp constructor.
     * @param \Magento\Captcha\Helper\Data $helper
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Session\SessionManagerInterface $session
     * @param \Magento\Framework\UrlInterface $urlManager
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Magento\Framework\App\Response\Http $http
     * @param \Magento\Framework\App\ResponseFactory $responseFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Textlocal $textlocal
     * @param Nexmo $nexmo
     * @param Voodoo $voodoo
     * @param Textmarketer $textmarketer
     * @param Twilio $twilio
     */
    public function __construct(
        \Magento\Captcha\Helper\Data $helper,
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Magento\Framework\UrlInterface $urlManager,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\Response\Http $http,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        ScopeConfigInterface $scopeConfig,
        Textlocal $textlocal,
        Nexmo $nexmo,
        Voodoo $voodoo,
        Textmarketer $textmarketer,
        Twilio $twilio
    ) {
        $this->_helper = $helper;
        $this->_actionFlag = $actionFlag;
        $this->messageManager = $messageManager;
        $this->_session = $session;
        $this->_urlManager = $urlManager;
        $this->redirect = $redirect;
        $this->http = $http;
        $this->responseFactory = $responseFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_textlocal = $textlocal;
        $this->_nexmo = $nexmo;
        $this->_voodoo = $voodoo;
        $this->_textmarketer = $textmarketer;
        $this->_twilio = $twilio;
    }

    /**
     * Check Captcha On User Login Page
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->scopeConfig->getValue('smsmarketing/otp/enabled_register')) {
            /** @var \Magento\Framework\App\Action\Action $controller */
            $controller = $observer->getControllerAction();
            $mobile_number = $controller->getRequest()->getParam('mobile_numbers');
            if ($mobile_number) {
                $content = '1234';
                /* send OTP here
                if ($this->_nexmo->isEnabled()) {
                    $this->_nexmo->sendSMS($content, $mobile_number);
                }
                if ($this->_textlocal->isEnabled()) {
                    $this->_textlocal->sendSMS($content, $mobile_number);
                }
                if ($this->_voodoo->isEnabled()) {
                    $this->_voodoo->sendSMS($content, $mobile_number);
                }
                if ($this->_textmarketer->isEnabled()) {
                    $this->_textmarketer->sendSMS($content, $mobile_number);
                }
                if ($this->_twilio->isEnabled()) {
                    $this->_twilio->sendSMS($content, $mobile_number);
                }
                */
                $this->_session->setCustomerFormData($controller->getRequest()->getPostValue());
                $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                $url = $this->_urlManager->getUrl('customer/account/form');
                $controller->getResponse()->setRedirect($url);
            }
        }

        return $this;
    }
}
