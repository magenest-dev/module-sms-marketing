<?php
/**
 * Created by Magenest
 * User: Luu Thanh Thuy
 * Date: 17/09/2016
 * Time: 14:34
 */
namespace Magenest\SmsMarketing\Plugin;

use Magenest\SmsMarketing\Helper\Data;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Class MobileAuthenticate
 * @package Magenest\SmsMarketing\Plugin
 */
class MobileAuthenticate
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param Data $helper
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        Data $helper
    ) {
        $this->_helper = $helper;
        $this->customerRepository =$customerRepository;
    }

    /**
     * @param \Magento\Customer\Model\AccountManagement $subject
     * @param $username
     * @param $password
     * @return array|null
     */
    public function beforeAuthenticate(\Magento\Customer\Model\AccountManagement $subject, $username, $password
    )
    {
        if ($this->_helper->checkExistingEmail($username)) {
            return null;
        }
        $email =$this->_helper->getEmailByMobile($username);
        if ($email) {
            return[$email,$password];
        } else {
            return null;
        }
    }
}
