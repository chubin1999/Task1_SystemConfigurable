<?php
/**
 * copyright © magento, inc. all rights reserved.
 * see copying.txt for license details.
 */
namespace aht\systemconfigurable\model\system\config\backend;

/**
 * backend for serialized array data
 */
class shipping extends \magento\framework\app\config\value
{
    /**
     * catalog inventory minsaleqty
     *
     * @var  \aht\systemconfigurable\helper\shipping
     */
    protected $_cataloginventoryminsaleqty = null;
    protected $config;

    /**
     * @param \magento\framework\model\context $context
     * @param \magento\framework\registry $registry
     * @param \magento\framework\app\config\scopeconfiginterface $config
     * @param \magento\framework\app\cache\typelistinterface $cachetypelist
     * @param \aht\systemconfigurable\helper\shipping $cataloginventoryminsaleqty
     * @param \magento\framework\model\resourcemodel\abstractresource $resource
     * @param \magento\framework\data\collection\abstractdb $resourcecollection
     * @param array $data
     */
    public function __construct(
        \magento\framework\model\context $context,
        \magento\framework\registry $registry,
        \magento\framework\app\config\scopeconfiginterface $config,
        \magento\framework\app\cache\typelistinterface $cachetypelist,
        \aht\systemconfigurable\helper\shipping $cataloginventoryminsaleqty,
        \magento\framework\model\resourcemodel\abstractresource $resource = null,
        \magento\framework\data\collection\abstractdb $resourcecollection = null,
        array $data = []
    ) {
        $this->_cataloginventoryminsaleqty = $cataloginventoryminsaleqty;
        $this->config = $config;
        parent::__construct($context, $registry, $config, $cachetypelist, $resource, $resourcecollection, $data);
    }

    /**
     * process data after load
     *
     * @return void
     */
    protected function _afterload()
    {
        $value = $this->getvalue();

        /*echo "<pre>";
        var_dump($value);
        die();*/
        /*if (is_array($value)) {
            $this->setvalue(implode('%', $data));
        }*/
        $value = $this->_cataloginventoryminsaleqty->makearrayfieldvalue($value);
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
        $this->setvalue($value);
       /* echo "<pre>";
        var_dump($this->getvalue());
        die;*/
    }

    /**
     * prepare data before save
     *
     * @return void
     */
    public function beforesave()
    {
       /* print_r($this->getdata());die;*/
       /* $value = $this->config->getvalue();*/
       $value = $this->getvalue();
       unset($value['__empty']);
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
        
        $value = $this->_cataloginventoryminsaleqty->makestorablearrayfieldvalue($value);
        /*echo "<pre>";
        var_dump($value);
        die();*/
        $this->setvalue($value);

        /*echo "<pre>";
        var_dump($this->getvalue());
        die;*/
    }
}
