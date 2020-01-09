<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SmsMarketing\Controller\Manage;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;

class Save extends \Magenest\SmsMarketing\Controller\Manage
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var \Magento\Newsletter\Model\SubscriberFactory
     */
    protected $subscriberFactory;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param CustomerRepository $customerRepository
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CustomerRepository $customerRepository,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
    ) {
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerRepository = $customerRepository;
        $this->subscriberFactory = $subscriberFactory;
        parent::__construct($context, $customerSession);
    }

    /**
     * Save newsletter subscription preference action
     *
     * @return void|null
     */
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customer/account/');
        }

        $customerId = $this->_customerSession->getCustomerId();
        if ($customerId === null) {
            $this->messageManager->addError(__('Something went wrong while saving your SMS subscription.'));
        } else {
            try {
                $customer = $this->customerRepository->getById($customerId);
                $storeId = $this->storeManager->getStore()->getId();
                $customer->setStoreId($storeId);
                $this->customerRepository->save($customer);
                if ((boolean)$this->getRequest()->getParam('is_subscribed', false)) {
                    $customer->setCustomAttribute('sms_subscription_status', '1');
                    $this->messageManager->addSuccess(__('We saved your SMS Marketing subscription.'));
                } else {
                    $customer->setCustomAttribute('sms_subscription_status', '0');
                    $this->messageManager->addSuccess(__('We removed your SMS Marketing subscription.'));
                }
                $this->customerRepository->save($customer);
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong while saving your SMS subscription.'));
            }
        }
        $this->_redirect('customer/account/');
    }
}
