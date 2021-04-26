<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\SystemConfigurable\Model;

use Magento\Quote\Model\ShippingMethodManagement;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\EstimateAddressInterface;
use Magento\Quote\Api\ShipmentEstimationInterface;
use Magento\Quote\Model\ResourceModel\Quote\Address as QuoteAddressResource;
use AHT\SystemConfigurable\Helper\Data;
use AHT\SystemConfigurable\Helper\Shipping;

class ShippingMethod extends ShippingMethodManagement
{
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor
     */
    protected $dataProcessor;

    /**
     * @var AddressInterfaceFactory $addressFactory
     */
    protected $addressFactory;

    /**
     * @var QuoteAddressResource
     */
    protected $quoteAddressResource;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    protected $data;

    protected $_shippingInventory;

    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Quote\Model\Cart\ShippingMethodConverter $converter,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Quote\Model\Quote\TotalsCollector $totalsCollector,
        AddressInterfaceFactory $addressFactory = null,
        QuoteAddressResource $quoteAddressResource = null,
        CustomerSession $customerSession = null,
        Data $data,
        Shipping $shippingInventory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->converter = $converter;
        $this->addressRepository = $addressRepository;
        $this->totalsCollector = $totalsCollector;
        $this->data = $data;
        $this->_shippingInventory = $shippingInventory;
        $this->addressFactory = $addressFactory ?: ObjectManager::getInstance()
        ->get(AddressInterfaceFactory::class);
        $this->quoteAddressResource = $quoteAddressResource ?: ObjectManager::getInstance()
        ->get(QuoteAddressResource::class);
        $this->customerSession = $customerSession ?? ObjectManager::getInstance()->get(CustomerSession::class);
    }
    /**
     * @inheritdoc
     */
    public function estimateByExtendedAddress($cartId, AddressInterface $address)
    {
      /*  $a = $this->data->getCustomerGroup();*/
        /*$b = $this->_objectManager->create('AHT\SystemConfigurable\Helper\Data')->getConfig('shippingmethod/shippingmethod/shipping_method_customer_group');
        $value = $this->_shippingInventory->makeArrayFieldValue($b);*/
        /*echo "<pre>";
        print_r($a);
        echo "<br>";
        print_r($value);
        die('die');*/

        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        // no methods applicable for empty carts or carts with virtual products
        if ($quote->isVirtual() || 0 == $quote->getItemsCount()) {
            return [];
        }
        return $this->getShippingMethods($quote, $address);
    }

    /*
     * Get list of available shipping methods
     */
    protected function getShippingMethods($quote, $address)
    {
        /*$a = $this->data->getCustomerGroup();*/
        $output = [];
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->addData($this->extractAddressData($address));
        $shippingAddress->setCollectShippingRates(true);

        $this->totalsCollector->collectAddressTotals($quote, $shippingAddress);
        $quoteCustomerGroupId = $quote->getCustomerGroupId();
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        $isCustomerGroupChanged = $quoteCustomerGroupId !== $customerGroupId;
        
        if ($isCustomerGroupChanged) {
            $quote->setCustomerGroupId($customerGroupId);
        }
        $shippingRates = $shippingAddress->getGroupedAllShippingRates();
        /*echo "<pre>";
        print_r($shippingRates);
        die('asd');*/
        foreach ($shippingRates as $carrierRates) {
            foreach ($carrierRates as $rate) {
                $output[] = $this->converter->modelToDataObject($rate, $quote->getQuoteCurrencyCode());
            }
        }
        if ($isCustomerGroupChanged) {
            $quote->setCustomerGroupId($quoteCustomerGroupId);
        }
        /*$checkData = $output->getData();
        print_r($checkData);*/
        /*die('asd');*/
        return $output;
    }

    /**
     * Get transform address interface into Array
     */
    protected function extractAddressData($address)
    {
        $className = \Magento\Customer\Api\Data\AddressInterface::class;
        if ($address instanceof \Magento\Quote\Api\Data\AddressInterface) {
            $className = \Magento\Quote\Api\Data\AddressInterface::class;
        } elseif ($address instanceof EstimateAddressInterface) {
            $className = EstimateAddressInterface::class;
        }
        return $this->getDataObjectProcessor()->buildOutputDataArray(
            $address,
            $className
        );
    }

    /*
     * Gets the data object processor
     */
    protected function getDataObjectProcessor()
    {
        if ($this->dataProcessor === null) {
            $this->dataProcessor = ObjectManager::getInstance()
            ->get(DataObjectProcessor::class);
        }
        return $this->dataProcessor;
    }
}
