<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\SmsMarketing\Controller\Customer;

use Magento\Framework\App\Action\Context;

class Form extends \Magento\Framework\App\Action\Action
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

//    /**
//     * @param \Magento\Captcha\Helper\Data $helper
//     * @param \Magento\Framework\App\ActionFlag $actionFlag
//     * @param \Magento\Framework\Message\ManagerInterface $messageManager
//     * @param \Magento\Framework\Session\SessionManagerInterface $session
//     * @param \Magento\Framework\UrlInterface $urlManager
//     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
//     */
//    public function __construct(
//        \Magento\Captcha\Helper\Data $helper,
//        \Magento\Framework\App\ActionFlag $actionFlag,
//        \Magento\Framework\Message\ManagerInterface $messageManager,
//        \Magento\Framework\Session\SessionManagerInterface $session,
//        \Magento\Framework\UrlInterface $urlManager,
//        \Magento\Framework\App\Response\RedirectInterface $redirect,
//        \Magento\Framework\App\Response\Http $http,
//        \Magento\Framework\App\ResponseFactory $responseFactory
//    ) {
//        $this->_helper = $helper;
//        $this->_actionFlag = $actionFlag;
//        $this->messageManager = $messageManager;
//        $this->_session = $session;
//        $this->_urlManager = $urlManager;
//        $this->redirect = $redirect;
//        $this->http = $http;
//        $this->responseFactory = $responseFactory;
//    }
    /**
     * Form constructor.
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
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
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
        parent::__construct($context);
    }

    /**
     * Managing newsletter subscription page
     *
     * @return void
     */
    public function execute()
    {
//        if($this->_session->getCustomerFormData()) {
        if(1) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Sms Registration'));
            return $resultPage;
        }
        else{
            $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
            $url = $this->_urlManager->getUrl('*/*/');
            $this->getResponse()->setRedirect($url);
        }
    }
}
