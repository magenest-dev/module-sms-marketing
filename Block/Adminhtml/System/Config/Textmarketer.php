<?php
/**
 * Created by PhpStorm.
 * User: heomep
 * Date: 01/12/2016
 * Time: 07:49
 */

namespace Magenest\SmsMarketing\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field as FormField;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Textmarketer extends FormField
{
    /**
     * Username
     *
     * @var string
     */
    protected $_username = 'smsmarketing_textmarketer_username';

    /**
     * Url
     *
     * @var string
     */
    protected $_password = 'smsmarketing_textmarketer_password';

    /**
     * @var string
     */
    protected $_number = 'smsmarketing_textmarketer_number';

    /**
     * Check Connect Textmarketer
     *
     * @var string
     */
    protected $_checkButtonLabel = 'Check Connect Textmarketer';

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
    public function setTextmarketerUsername($username)
    {
        $this->_username = $username;
        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getTextmarketerUsername()
    {
        return $this->_username;
    }

    /**
     * Set Hash
     *
     * @param $hash
     * @return $this
     */
    public function setTextmarketerPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * Get Hash
     *
     * @return string
     */
    public function getTextmarketerPassword()
    {
        return $this->_password;
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
            $this->setTemplate('system/config/textmarketer/check.phtml');
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
