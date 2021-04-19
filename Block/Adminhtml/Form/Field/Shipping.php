<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AHT\SystemConfigurable\Block\Adminhtml\Form\Field;

/**
 * Adminhtml catalog inventory "Minimum Qty Allowed in Shopping Cart" field
 *
 * @api
 * @since 100.0.2
 *
 * @deprecated 100.3.0 Replaced with Multi Source Inventory
 * @link https://devdocs.magento.com/guides/v2.3/inventory/index.html
 * @link https://devdocs.magento.com/guides/v2.3/inventory/catalog-inventory-replacements.html
 */
class Shipping extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @var Customergroup
     */
    protected $_groupRenderer;
    protected $_shippingMethod;

    /**
     * Retrieve group column renderer
     *
     * @return Customergroup
     */
    protected function _getGroupRenderer()
    {
        if (!$this->_groupRenderer) {
            $this->_groupRenderer = $this->getLayout()->createBlock(
                \AHT\SystemConfigurable\Block\Adminhtml\Form\Field\Customergroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
             $this->_groupRenderer->setClass('customer_group_select admin__control-select validate-select required-entry');
        }
        return $this->_groupRenderer;
    }

    protected function _getShipping()
    {
        if (!$this->_shippingMethod) {
            $this->_shippingMethod = $this->getLayout()->createBlock(
               \AHT\SystemConfigurable\Block\Adminhtml\Form\Field\ActiveShippingMethod::class,
               '',
               ['data' => ['is_render_to_js_template' => true]]
           );
            $this->_shippingMethod->setClass('shipping_method_select admin__control-select validate-select required-entry');
        }
        /*echo "<pre>";
        var_dump($this->_shippingMethod);
        die('asd');*/
        return $this->_shippingMethod;
    }

    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'shipment_id',
            [
                'label' => __('Shipping Method'),
                'renderer' => $this->_getShipping()
            ]
        );
       /* $this->addColumn(
            'min_sale_qty',
            [
                'label' => __('Minimum Qty'),
                'class' => 'required-entry validate-number validate-greater-than-zero admin__control-text'
            ]
        );*/
        $this->addColumn(
            'customer_group_id',
            [
                'label' => __('Customer Group'), 
                'renderer' => $this->_getGroupRenderer(),
                'extra_params' => 'multiple="multiple"'/*,
                'class' => 'required-entry validate-number validate-greater-than-zero admin__control-text validate-email validate-select'*/
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New');
    }
    
    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        /*$options = [];*/
        
        /*echo "<pre>";
        print_r($row->getData());
        die();*/

        /*$optionExtraAttr['option_' . $this->_getGroupRenderer()->calcOptionHash($row->getData('customer_group_id'))] =
        'selected';*/

        $customer = $row->getData('customer_group_id');
        foreach ($customer as $value) {
            $optionExtraAttr['option_' . $this->_getGroupRenderer()->calcOptionHash($value)]
            = 'selected="selected"';
        }

        $optionExtraAttr['option_' . $this->_getShipping()->calcOptionHash($row->getData('shipment_id'))] =
        'selected="selected"';


        /*$customerGroup = $row->getData('shipment_id');
        $optionExtraAttr['option_' . $this->_getGroupRenderer()->calcOptionHash($customerGroup)] = 'selected="selected"';*/

        /*$countries = $row->getCountry();
        if (count($countries) > 0) {
            foreach ($countries as $country) {
                $options['option_' . $this->getCountryRenderer()->calcOptionHash($country)]
                = 'selected="selected"';
            }
        }*/
/*
        $customer = $row->getData('customer_group_id');
        foreach ($customer as $value) {
            $options['option_' . $this->_getGroupRenderer()->calcOptionHash($value)]
            = 'selected="selected"';
        }*/

        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
        /*print_r($row->getData());
        die;*/

    }
}
