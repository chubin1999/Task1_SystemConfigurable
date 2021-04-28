<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AHT\SystemConfigurable\Helper;

use Magento\Customer\Api\GroupManagementInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\Store;

/**
 * MinSaleQty value manipulation helper
 */
class Shipping
{
    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Math\Random
     */
    protected $mathRandom;

    /**
     * @var GroupManagementInterface
     */
    protected $groupManagement;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * @var array
     */
    private $minSaleQtyCache = [];

    protected $ShippingManagement;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param GroupManagementInterface $groupManagement
     * @param Json|null $serializer
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Math\Random $mathRandom,
        GroupManagementInterface $groupManagement,
        Json $serializer = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->mathRandom = $mathRandom;
        $this->groupManagement = $groupManagement;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
    }

    /**
     * Retrieve fixed qty value
     * Truy xuất giá trị qty cố định
     *
     * @param int|float|string|null $qty
     * @return float|null
     */
    /*protected function fixQty($qty)
    {
        return !empty($qty) ? (float) $qty : null;
    }*/

    /**
     * Generate a storable representation of a value
     * Tạo một biểu diễn đáng lưu ý của một giá trị
     *
     * @param int|float|string|array $value
     * @return string
     */
    protected function serializeValue($value)
    {
        /*if (is_numeric($value)) {
            $data = (float) $value;
            return (string) $data;
        } elseif (is_array($value)) {
            $data = [];
            foreach ($value as $groupId => $qty) {
                if (!array_key_exists($groupId, $data)) {
                    $data[$groupId] = $this->fixQty($qty);
                }
            }
            if (count($data) == 1 && array_key_exists($this->getAllCustomersGroupId(), $data)) {
                return (string) $data[$this->getAllCustomersGroupId()];
            }
            return $this->serializer->serialize($data);
        } else {
            return $value;
        }*/

        if (is_numeric($value)) {
            $data = (float) $value;
            return (string) $data;
        } elseif (is_array($value)) {
            $data = [];
            foreach ($value as $groupId => $qty) {
                if (!array_key_exists($groupId, $data)) {
                    $data[$groupId] = $qty;
                }
            }
            if (count($data) == 1 && array_key_exists($this->getAllCustomersGroupId(), $data)) {
                return (string) $data[$this->getAllCustomersGroupId()];
            }
           /* echo "<pre>";
            var_dump($data);
            die('abc');*/
            return $this->serializer->serialize($data);
        } else {
            return $value;
        }
    }

    /**
     * Create a value from a storable representation
     * Tạo một giá trị từ một biểu diễn lưu trữ
     *
     * @param int|float|string $value
     * @return array
     */
    protected function unserializeValue($value)
    {
        /*if (is_numeric($value)) {
            return [$this->getAllCustomersGroupId() => $this->fixQty($value)];
        } elseif (is_string($value) && !empty($value)) {
            return $this->serializer->unserialize($value);
        } else {
            return [];
        }*/
        if (is_numeric($value)) {
            return [$this->getAllCustomersGroupId()/* => $this->getAllShippingMethodId()*/];
        } elseif (is_string($value) && !empty($value)) {
            return $this->serializer->unserialize($value);
        } else {
            return [];
        }
    }

    /**
     * Check whether value is in form retrieved by _encodeArrayFieldValue()
     * Kiểm tra xem giá trị có ở dạng được truy xuất bởi _encodeArrayFieldValue() hay không
     *
     * @param string|array $value
     * @return bool
     */
    protected function isEncodedArrayFieldValue($value)
    {

        /*if (!is_array($value)) {
            return false;
        }
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('min_sale_qty', $row)
            ) {
                return false;
            }
        }
        return true;*/
        /*if (!is_array($value)) {
            return false;
        }*/
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('shipment_id', $row)
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Encode value to be used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     * Mã hóa giá trị được sử dụng \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function encodeArrayFieldValue(array $value)
    {
        /*$result = [];
        foreach ($value as $groupId => $qty) {
            $resultId = $this->mathRandom->getUniqueHash('_');
            $result[$resultId] = ['customer_group_id' => $groupId, 'min_sale_qty' => $this->fixQty($qty)];
        }
        return $result;*/
        $result = [];
        foreach ($value as $key => $groupId) {
            $resultId = $this->mathRandom->getUniqueHash('_');
            $result[$resultId] = ['shipment_id' => $key,'customer_group_id' => $groupId ];
        }
        /*echo "<pre>";
        var_dump($result);
        die('aaa');*/
        return $result;
        
    }

    /**
     * Decode value from used in \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     * Giải mã giá trị từ được sử dụng trong \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param array $value
     * @return array
     */
    protected function decodeArrayFieldValue(array $value)
    {
        /*$result = [];
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('min_sale_qty', $row)
            ) {
                continue;
            }
            $groupId = $row['customer_group_id'];
            $qty = $this->fixQty($row['min_sale_qty']);
            $result[$groupId] = $qty;
        }
        return $result;*/

        $result = [];
        /*unset($value['__empty']);*/
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('shipment_id', $row)
            ) {
                continue;
            }
            $groupId = $row['customer_group_id'];
            $shipmentId = $row['shipment_id'];
            $result[$shipmentId] = $groupId;
            /*$result[$groupId] = $shipmentId;*/
            /*echo "<pre>";
            var_dump($groupId);
            die;*/
        }
        /*echo "<pre>";
        var_dump($result[$groupId]);
        die;*/
        return $result;
    }

    /**
     * Retrieve min_sale_qty value from config
     * Truy xuất giá trị min_sale_qty từ cấu hình
     *
     * @param int $customerGroupId
     * @param null|string|bool|int|Store $store
     * @return float|null
     */
    public function getConfigValue($customerGroupId, $store = null)
    {
        $key = $customerGroupId . '-' . $store;
        if (!isset($this->minSaleQtyCache[$key])) {
            $value = $this->scopeConfig->getValue(
                \Magento\CatalogInventory\Model\Configuration::XML_PATH_MIN_SALE_QTY,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                $store
            );
            $value = $this->unserializeValue($value);
            if ($this->isEncodedArrayFieldValue($value)) {
                $value = $this->decodeArrayFieldValue($value);
            }
            $result = null;
            foreach ($value as $groupId => $qty) {
                if ($groupId == $customerGroupId) {
                    $result = $qty;
                    break;
                } elseif ($groupId == $this->getAllCustomersGroupId()) {
                    $result = $qty;
                }
            }
            $this->minSaleQtyCache[$key] = $this->fixQty($result);
        }
        return $this->minSaleQtyCache[$key];
    }

    /**
     * Make value readable by \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     * Làm cho giá trị có thể đọc được bởi \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
     *
     * @param string|array $value
     * @return array
     */
    public function makeArrayFieldValue($value)
    {
        $value = $this->unserializeValue($value);
        /*if (!$this->isEncodedArrayFieldValue($value)) {*/
            $value = $this->encodeArrayFieldValue($value);
        /*}*/
        return $value;
    }

    /**
     * Make value ready for store
     * Làm cho giá trị sẵn sàng cho cửa hàng
     *
     * @param string|array $value
     * @return string
     */
    public function makeStorableArrayFieldValue($value)
    {
       /* if ($this->isEncodedArrayFieldValue($value)) {*/
            $value = $this->decodeArrayFieldValue($value);
            /*echo "<pre>";
            var_dump($value);
            die();*/
        /*}*/
        $value = $this->serializeValue($value);
        return $value;
    }

    /**
     * Return the all customer group id
     * Trả lại tất cả id nhóm khách hàng
     *
     * @return int
     */
    protected function getAllCustomersGroupId()
    {
        return $this->groupManagement->getAllCustomersGroup()->getId();
    }

   /* protected function getAllShippingMethodId()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Api\Data\OrderInterface')->load($orderid);
        $shippingMethod = $order->getShippingDescription();
        $order->getShippingMethod();
        return $order;
    }*/
}
