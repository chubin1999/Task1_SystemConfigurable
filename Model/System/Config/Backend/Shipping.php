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
        $value = $this->_catalogInventoryMinsaleqty->makeArrayFieldValue($value);
        $this->setValue($value);
    }

    /**
     * prepare data before save
     *
     * @return void
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        $value = $this->_catalogInventoryMinsaleqty->makeStorableArrayFieldValue($value);
        $this->setValue($value);
    }
}
