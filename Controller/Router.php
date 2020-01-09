<?php
namespace Magenest\SmsMarketing\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Event manager
     *
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Page factory
     *
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $_pageFactory;

    /**
     * Config primary
     *
     * @var \Magento\Framework\App\State
     */
    protected $_appState;

    /**
     * Url
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    protected $allowedActions;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResponseInterface $response,
        array $allowedActions = []
    ) {
        $this->actionFactory = $actionFactory;
        $this->_eventManager = $eventManager;
        $this->_url = $url;
        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_response = $response;
        $this->allowedActions = $allowedActions;
    }
    public function match(\Magento\Framework\App\RequestInterface $request) {
        $info = $request->getPathInfo();
        $pattern = '/^(' . implode('|', $this->allowedActions) . ')$/i';
        if (preg_match("%^/(customer)/(account)/(.*?)$%", $info, $m)) {
            if(preg_match($pattern, $m[3])) {
                $request->setPathInfo(sprintf("/%s/%s/%s", 'smsmarketing', 'customer', $m[3]));
                return $this->actionFactory->create('Magento\Framework\App\Action\Forward',
                    ['request' => $request]);
            }
        }
        return null;
    }
}