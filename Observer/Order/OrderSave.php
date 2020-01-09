<?php
/**
 * Created by Magenest.
 * Date: 26/11/2016
 * Time: 09:54
 */
namespace Magenest\SmsMarketing\Observer\Order;

use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magenest\SmsMarketing\Model\Textlocal\SendSms as Textlocal;
use Magenest\SmsMarketing\Model\Nexmo\SendSms as Nexmo;
use Magenest\SmsMarketing\Model\Voodoo\SendSms as Voodoo;
use Magenest\SmsMarketing\Model\Textmarketer\SendSms as Textmarketer;
use Magenest\SmsMarketing\Model\Twilio\SendSms as Twilio;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Sales\Model\Order;
use Magento\Customer\Model\Customer;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class OrderSave
 * @package Magenest\SmsMarketing\Observer\Order
 */
class OrderSave implements ObserverInterface
{

    /**
     * @var Textlocal
     */
    protected $_textlocal;

    /**
     * @var CurrentCustomer
     */
    protected $_currCustomer;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Customer
     */
    protected $customer;

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
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param Textlocal $textlocal
     * @param CurrentCustomer $currentCustomer
     * @param Order $order
     * @param Customer $customer
     */
    public function __construct(
        Textlocal $textlocal,
        ScopeConfigInterface $scopeConfig,
        Nexmo $nexmo,
        Voodoo $voodoo,
        Textmarketer $textmarketer,
        Twilio $twilio,
        CurrentCustomer $currentCustomer,
        Order $order,
        Customer $customer
    ) {
        $this->customer = $customer;
        $this->order = $order;
        $this->_currCustomer = $currentCustomer;
        $this->_scopeConfig = $scopeConfig;
        $this->_textlocal = $textlocal;
        $this->_nexmo = $nexmo;
        $this->_voodoo = $voodoo;
        $this->_textmarketer = $textmarketer;
        $this->_twilio = $twilio;
    }


    /**
     * Handler for 'customer_logout' event.
     *
     * @param  Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        $orderId =$order->getId();
        $orderTotal = $order->getBaseGrandTotal();
        $statusBefore =  $order->getOrigData('status');
        $statusAfter = $order->getStatus();
        if (($statusBefore == null) && ($this->_scopeConfig->getValue('smsmarketing/content/enabled_order'))) {
            $content = $this->_scopeConfig->getValue('smsmarketing/content/order_success');
        } elseif (($statusBefore != $statusAfter) && ($this->_scopeConfig->getValue('smsmarketing/content/enabled_update'))) {
            $content = $this->_scopeConfig->getValue('smsmarketing/content/update_status');
        }
        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        $customer = $this->customer->load($order->getCustomerId());
        if ($customer->getSmsSubscriptionStatus()) {
            $status = $customer->getSmsSubscriptionStatus();
        } else {
            $status = false;
        }
        $phoneNumber = $customer->getMobileNumbers();
        $increment_id = $order->getIncrementId();
        $customerName =$customer->getFirstname();

        $replaceString = [
            '{{order_id}}' => $increment_id,
            '{{customer_name}}' => $customerName,
            '{{order_base_grand_totals}}' => $orderTotal,
            '{{old_status}}' => $statusBefore,
            '{{new_status}}' => $statusAfter
        ];
        if ($phoneNumber && $status && isset($content)) {
            $newContent = strtr($content, $replaceString);
            if ($this->_nexmo->isEnabled()) {
                $this->_nexmo->sendSMS($newContent, $phoneNumber);
            }
            if ($this->_textlocal->isEnabled()) {
                $this->_textlocal->sendSMS($newContent, $phoneNumber);
            }
            if ($this->_voodoo->isEnabled()) {
                $this->_voodoo->sendSMS($newContent, $phoneNumber);
            }
            if ($this->_textmarketer->isEnabled()) {
                $this->_textmarketer->sendSMS($newContent, $phoneNumber);
            }
            if ($this->_twilio->isEnabled()) {
                $this->_twilio->sendSMS($newContent, $phoneNumber);
            }
        }
    }
}
