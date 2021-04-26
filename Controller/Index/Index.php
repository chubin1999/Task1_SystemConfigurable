<?php
namespace AHT\SystemConfigurable\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use AHT\SystemConfigurable\Helper\Data;
use AHT\SystemConfigurable\Helper\Shipping;
use AHT\SystemConfigurable\Model\ShippingMethod;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    protected $data;

    protected $_shippingInventory;

    protected $shippingMethod;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Data $data,
        Shipping $shippingInventory,
        ShippingMethod $shippingMethod
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->data = $data;
        $this->_shippingInventory = $shippingInventory;
        $this->shippingMethod = $shippingMethod;
        parent::__construct($context);
    }
    
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $a = $this->data->getCustomerGroup();
        $b = $this->_objectManager->create('AHT\SystemConfigurable\Helper\Data')->getConfig('shippingmethod/shippingmethod/shipping_method_customer_group');
        //Make array field value
        $value = $this->_shippingInventory->makeArrayFieldValue($b);
        /*$c = $this->shippingMethod->estimateByExtendedAddress(1,2);
        echo "<pre>";
        print_r($c);*/
        echo "<pre>";
        print_r($a);
        echo "<br>";
        print_r($value);
        die('');
        return $resultPage;
    }
}
