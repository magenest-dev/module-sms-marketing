<?php
/**
 * Created by PhpStorm.
 * User: heomep
 * Date: 04/12/2016
 * Time: 09:03
 */

namespace Magenest\SmsMarketing\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field as FormField;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Twilio extends FormField
{
    /**
     * Username
     *
     * @var string
     */
    protected $_sid = 'smsmarketing_twilio_sid';

    /**
     * Url
     *
     * @var string
     */
    protected $_token = 'smsmarketing_twilio_token';

    /**
     * @var string
     */

    protected $_from = 'smsmarketing_twilio_from';

    protected $_number = 'smsmarketing_twilio_number';

    /**
     * Check Connect Textmarketer
     *
     * @var string
     */
    protected $_checkButtonLabel = 'Check Connect Twilio';

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
    public function setTwilioId($sid)
    {
        $this->_sid = $sid;
        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getTwilioId()
    {
        return $this->_sid;
    }

    /**
     * Set Hash
     *
     * @param $hash
     * @return $this
     */
    public function setTwilioToken($token)
    {
        $this->_token = $token;
        return $this;
    }

    /**
     * Get Hash
     *
     * @return string
     */
    public function getTwilioToken()
    {
        return $this->_token;
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
     * @return \Magenest\SmsMarketing\Block\Adminhtml\System\Config\Textmarketer
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/twilio/check.phtml');
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
