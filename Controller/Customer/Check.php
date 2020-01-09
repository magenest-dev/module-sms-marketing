<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SmsMarketing\Controller\Customer;

use Magento\Framework\App\Action\Context;

class Check extends \Magento\Framework\App\Action\Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;

    /**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;

    /**
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlManager;


    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;
    protected $http;
    protected $responseFactory;
    protected $createPost;

    /**
     * Check constructor.
     * @param Context $context
     * @param \Magento\Captcha\Helper\Data $helper
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Session\SessionManagerInterface $session
     * @param \Magento\Framework\UrlInterface $urlManager
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Magento\Framework\App\Response\Http $http
     * @param \Magento\Framework\App\ResponseFactory $responseFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Customer\Controller\Account\CreatePost $createPost
     */
    public function __construct(
        Context $context,
        \Magento\Captcha\Helper\Data $helper,
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Magento\Framework\UrlInterface $urlManager,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\Response\Http $http,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Controller\Account\CreatePost $createPost
    )
    {
        $this->_helper = $helper;
        $this->_actionFlag = $actionFlag;
        $this->messageManager = $messageManager;
        $this->_session = $session;
        $this->_urlManager = $urlManager;
        $this->redirect = $redirect;
        $this->http = $http;
        $this->responseFactory = $responseFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->createPost  = $createPost;
        parent::__construct($context);
    }

    /**
     * Save newsletter subscription preference action
     *
     * @return void|null
     */
    public function execute()
    {
        $otp = $this->getRequest()->getParam('otp');
        if($otp == '1234'){
            $params = $this->_session->getCustomerFormData();
            $this->_request->setParams($params);
            $this->_session->unsCustomerFormData();
            $redirect = $this->createPost->execute();
            return $redirect;
        }
        else {
            $this->messageManager->addError(__('Incorrect OTP'));
            $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
            $url = $this->_urlManager->getUrl('smsmarketing/customer/form');
            $this->getResponse()->setRedirect($this->redirect->error($url));
        }
    }
}
