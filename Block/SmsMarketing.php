<?php
/**
 * Created by Magenest.
 * Date: 02/12/2016
 * Time: 09:35
 */
namespace Magenest\SmsMarketing\Block;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * Customer front  sms manage block
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class SmsMarketing extends \Magento\Customer\Block\Account\Dashboard
{
    /**
     * @var string
     */
    protected $_template = 'form/smsmarketing.phtml';

    /**
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsSubscribed()
    {
        if (!$this->getCustomer()->getCustomAttribute('sms_subscription_status')) {
            return false;
        } else {
            return $this->getCustomer()->getCustomAttribute('sms_subscription_status')->getValue();
        }
    }

    /**
     * Return the save action Url.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl('smsmarketing/manage/save');
    }
}
