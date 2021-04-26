<?php 

namespace AHT\SystemConfigurable\Helper;

class Data
{
	protected $_customerSession;

	protected $_customerGroupCollection;

	protected $scopeConfig;

	public function __construct(
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Customer\Model\Group $customerGroupCollection,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	) {

		$this->_customerSession = $customerSession;
		$this->_customerGroupCollection = $customerGroupCollection;
		$this->scopeConfig = $scopeConfig;
	}

	public function getCustomerGroup()
	{	
		//Get customer group Id , you have already this so directly get name
		$currentGroupId = $this->_customerSession->getCustomer()->getGroupId(); 

		$collection = $this->_customerGroupCollection->load($currentGroupId); 

        //Get group name
		/*$groupName = $collection->getCustomerGroupCode();*/

        //Get group id
		$groupName = $collection->getCustomerGroupId(); 
		return $groupName;
	}

	public function getConfig($config_path)
	{
		return $this->scopeConfig->getValue(
			$config_path,
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	public function getShippingMethodByCustomerGroup()
	{
		$a = "abc";
		return $a; 
	}

}