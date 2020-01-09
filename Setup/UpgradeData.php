<?php

namespace Magenest\SmsMarketing\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $this->upgradeMobileNumber($setup);
        }
    }

    /**
     * @param $setup
     */
    private function upgradeMobileNumber($setup)
    {
        $installer = $setup;
        $installer->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'mobile_numbers',
            array(
                'type'     => 'varchar',
                'backend'  => '',
                'label'    => 'Mobile Number',
                'input'    => 'text',
                'source'   => '',
                'visible'  => true,
                'required' => false,
                'default'  => '',
                'frontend' => '',
                'unique'   => false,
                'note'     => '',
            )
        );
        $my_attribute    = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'mobile_numbers');
        $used_in_forms[] = 'adminhtml_customer';
        $used_in_forms[] = 'checkout_register';
        $used_in_forms[] = 'customer_account_create';
        $used_in_forms[] = 'customer_account_edit';
        $used_in_forms[] = 'adminhtml_checkout';
        $used_in_forms[] = 'smsmarketing_manage_index';
        $used_in_forms[] = 'smsmarketing_manage_save';
        $my_attribute->setData('used_in_forms', $used_in_forms)->setData('is_used_for_customer_segment', true)->setData('is_system', 0)
            ->setData('is_user_defined', 1)->setData('is_visible', 1)->setData('sort_order', 100) ->setData("is_used_in_grid", 1)
            ->setData("is_visible_in_grid", 1)
            ->setData("is_filterable_in_grid", 1)
            ->setData("is_searchable_in_grid", 1);
        $my_attribute->save();
    }
}
