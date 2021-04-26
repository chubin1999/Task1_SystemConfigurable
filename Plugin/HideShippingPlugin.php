<?php

namespace AHT\SystemConfigurable\Plugin;

class HideShippingPlugin {
    public function aroundCollectCarrierRates(
        \Magento\Shipping\Model\Shipping $subject,
        \Closure $proceed,
        $carrierCode,
        $request
    ) {
        // Hide all shipping methods except free shipping method
        if ($carrierCode != 'freeshipping') {
            return false;;
        } 
        $result = $proceed($carrierCode, $request);
        return $result;
    }
}