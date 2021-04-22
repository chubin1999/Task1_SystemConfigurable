<?php
/**
 * copyright © magento, inc. all rights reserved.
 * see copying.txt for license details.
 */
namespace AHT\SystemConfigurable\Model\System\Config\Backend;

/**
 * backend for serialized array data
 */
class Shipping extends \Magento\Framework\App\Config\Value
{
    /**
     * catalog inventory minsaleqty
     *
     * @var  \AHT\SystemConfigurable\Helper\Shipping
     */
    protected $_catalogInventoryMinsaleqty = null;
    protected $config;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \AHT\SystemConfigurable\Helper\Shipping $catalogInventoryMinsaleqty
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \AHT\SystemConfigurable\Helper\Shipping $catalogInventoryMinsaleqty,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_catalogInventoryMinsaleqty = $catalogInventoryMinsaleqty;
        $this->config = $config;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * process data after load
     *
     * @return void
     */
    protected function _afterLoad()
    {
        $value = $this->getValue();

        /*echo "<pre>";
        var_dump($value);
        die();*/
        /*if (is_array($value)) {
            $this->setvalue(implode('%', $data));
        }*/
        $value = $this->_catalogInventoryMinsaleqty->makeArrayFieldValue($value);
        /*if (is_array($value)) {
            $this->setvalue(implode(',', $data));
        }*/
        /*var_dump( explode( ',', $value ) );
        die('ad');*/
        /*echo "<pre>";
        var_dump($value);
        die();*/
       /* echo "<pre>";
        print_r($value);
        die();*/
        $this->setValue($value);
        /*echo "<pre>";
        var_dump($this->getvalue());
        die;*/
    }

    /**
     * prepare data before save
     *
     * @return void
     */
    public function beforeSave()
    {
       /* print_r($this->getdata());die;*/
       /* $value = $this->config->getvalue();*/
       $value = $this->getValue();
       /*unset($value['__empty']);*/
       /* echo "<pre>";
        var_dump($value);
        die();*/
        /*if (!empty($value['customer_group_id'])) {
            echo "abc";
            die();
        }
        else{
            echo "sai";
            die('asdsad');
        }*/
       /* $config = $this->_objectmanager->get('magento\framework\app\config\scopeconfiginterface')->getvalue('section/group/field');
        $values = (array)json_decode($config, true);
        $i = 0;
        foreach ($values as $value) {
            $start = $value['start_range'];
            $end = $value['end_range'];
            $percent = $value['mode'];
        }*/
        /*echo "<pre>";
        var_dump($value);
        die();*/
        
        $value = $this->_catalogInventoryMinsaleqty->makeStorableArrayFieldValue($value);
        /*echo "<pre>";
        var_dump($value);
        die();*/
        $this->setValue($value);

        /*echo "<pre>";
        var_dump($this->getvalue());
        die;*/
    }
}
