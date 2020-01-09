<?php
/**
 * Created by Magenest.
 * Date: 23/11/2016
 * Time: 10:07
 */
namespace Magenest\SmsMarketing\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;

/**
 * Class Data
 * @package Magenest\SmsMarketing\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_PATH_CONFIG_MOBILE_LOGIN = 'smsmarketing/mobile_login_option/mobile_login_enabled';

    const XML_PATH_CONFIG_MOBILE_ENABLE = 'smsmarketing/mobile_login_option/enable';
    
    const XML_PATH_CONFIG_MOBILE_REQUIRED = 'smsmarketing/mobile_login_option/is_required';


    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    protected $_customersFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param StoreManagerInterface $storeManagerInterface
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customersFactory
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        StoreManagerInterface $storeManagerInterface,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customersFactory,
        CustomerFactory $customerFactory
    ) {
    

        $this->_customersFactory = $customersFactory;
        $this->_scopeConfig = $context->getScopeConfig();
        $this->customerFactory = $customerFactory;
        $this->_storeManager = $storeManagerInterface;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function getIsEnableMobileInput()
    {
        $enable = $this->_scopeConfig->getValue(self::XML_PATH_CONFIG_MOBILE_ENABLE);

        if ($enable == '1') {
            return true;
        } else {
            return false;
        }
    }
    public function getIsEnableMobileLogin()
    {
        $enable = $this->_scopeConfig->getValue(self::XML_PATH_CONFIG_MOBILE_LOGIN);

        if ($enable == '1') {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @return \Magento\Framework\App\RequestInterface
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return bool
     */
    public function getIsMobileInputRequire()
    {
        $required = $this->_scopeConfig->getValue(self::XML_PATH_CONFIG_MOBILE_REQUIRED);

        if ($required == '1') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $mobile
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEmailByMobile($mobile)
    {
        /**
         * @var \Magento\Customer\Model\Customer $customer
         */
        $customer = $this->_customersFactory->create()->addAttributeToFilter(
            'mobile_numbers',
            $mobile
        )->getFirstItem();
        return $customer->getEmail();
    }

    /**
     * @param $email
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function checkExistingEmail($email)
    {
        /**
         * @var \Magento\Customer\Model\Customer $customer
         */
        $customer = $this->_customersFactory->create()->addAttributeToFilter(
            'email',
            $email
        )->getFirstItem();
        if ($customer->getEmail()) {
            return true;
        }
        return false;
    }
}
