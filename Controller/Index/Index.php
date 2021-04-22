<?php
namespace AHT\SystemConfigurable\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use AHT\SystemConfigurable\Helper\Data;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    protected $data;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Data $data
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->data = $data;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $a = $this->data->getCustomerGroup();
        $b = $this->_objectManager->create('AHT\SystemConfigurable\Helper\Data')->getConfig('shippingmethod/shippingmethod/shipping_method_customer_group');
        echo "<pre>";
        print_r($a);
        echo "<br>";
        print_r($b);
        die('');
        return $resultPage;
    }
}
