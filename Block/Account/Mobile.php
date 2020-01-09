<?php
/**
 * Created by Magenest
 * User: Luu Thanh Thuy
 * Date: 17/06/2016
 * Time: 13:57
 */
namespace Magenest\SmsMarketing\Block\Account;

use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Class Mobile
 * @package Magenest\SmsMarketing\Block\Account
 */
class Mobile extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magenest\SmsMarketing\Helper\Data
     */
    protected $helper;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerSession
     */
    protected $_customerSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magenest\SmsMarketing\Helper\Data $dataHelper
     * @param CustomerSession $customerSession
     * @param CustomerFactory $customerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenest\SmsMarketing\Helper\Data $dataHelper,
        CustomerSession $customerSession,
        CustomerFactory $customerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_customerSession = $customerSession;
        $this->helper = $dataHelper;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @return bool
     */
    public function isMobileRequired()
    {
        return $this->helper->getIsMobileInputRequire();
    }

    /**
     * @return mixed
     */
    public function getAccountInfo()
    {
        $customerInfo = $this->customerFactory->create()->load($this->getCustomerId());
        return $customerInfo->getMobileNumbers();
    }

    /**
     * @return int|null
     */
    public function getCustomerId()
    {
        $customerId = $this->_customerSession->getCustomerId();

        return $customerId;
    }
}
