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
 * Class Nexmo
 *
 * @package Magenest\SmsMarketing\Block\Adminhtml\System\Config
 */
class Nexmo extends FormField
{
    /**
     * Username
     *
     * @var string
     */
    protected $_apiKey = 'smsmarketing_nexmo_api_key';

    /**
     * Url
     *
     * @var string
     */
    protected $_apiSecret = 'smsmarketing_nexmo_api_secret';

    /**
     * @var string
     */
    protected $_number = 'smsmarketing_nexmo_number';

    /**
     * Check Connect Nexmo
     *
     * @var string
     */
    protected $_checkButtonLabel = 'Check Connect Nexmo';

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
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->_apiKey;
    }

    /**
     * @param $apiSecret
     * @return $this
     */
    public function setApiSecret($apiSecret)
    {
        $this->_apiSecret = $apiSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->_apiSecret;
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
     * @return \Magenest\SmsMarketing\Block\Adminhtml\System\Config\Nexmo
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/nexmo/check.phtml');
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
