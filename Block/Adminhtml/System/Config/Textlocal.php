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
namespace Magenest\SmsMarketing\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field as FormField;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Textlocal
 *
 * @package Magenest\SmsMarketing\Block\Adminhtml\System\Config
 */
class Textlocal extends FormField
{
    /**
     * Username
     *
     * @var string
     */
    protected $_email = 'smsmarketing_integration_textlocal_email';

    /**
     * Url
     *
     * @var string
     */
    protected $_hash = 'smsmarketing_integration_textlocal_hash';

    /**
     * @var string
     */
    protected $_number = 'smsmarketing_integration_textlocal_number';

    /**
     * Check Connect Textlocal
     *
     * @var string
     */
    protected $_checkButtonLabel = 'Check Connect Textlocal';

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->_number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->_number;
    }

    /**
     * Set Email
     *
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->_email = $email;
        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Set Hash
     *
     * @param $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->_hash = $hash;
        return $this;
    }

    /**
     * Get Hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->_hash;
    }

    /**
     * Set Get Auth Token Button label
     *
     * @param  $getAuthButtonLabel
     * @return $this
     */
    public function setButtonLabel($getCheckButtonLabel)
    {
        $this->_checkButtonLabel = $getCheckButtonLabel;
        return $this;
    }

    /**
     * Set template to itself
     *
     * @return \Magenest\SmsMarketing\Block\Adminhtml\System\Config\Textlocal
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/textlocal/check.phtml');
        }

        return $this;
    }

    /**
     * Unset some non-related element parameters
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $buttonLabel  = !empty($originalData['button_label']) ? $originalData['button_label'] : $this->_checkButtonLabel;
        $this->addData(
            [
             'button_label' => __($buttonLabel),
             'html_id'      => $element->getHtmlId(),
             'ajax_url'     => $this->_urlBuilder->getUrl('smsmarketing/system_config/check'),
            ]
        );

        return $this->_toHtml();
    }
}
