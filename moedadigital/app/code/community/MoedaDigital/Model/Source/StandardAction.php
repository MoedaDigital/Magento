<?php
/**
 *
 * MoedaDigital 
 *
 **/
class Mage_MoedaDigital_Model_Source_StandardAction
{
    public function toOptionArray()
    {
        return array(
            array('value' => Mage_MoedaDigital_Model_Standard::PAYMENT_TYPE_AUTH, 'label' => Mage::helper('MoedaDigital')->__('Authorization')),
            array('value' => Mage_MoedaDigital_Model_Standard::PAYMENT_TYPE_SALE, 'label' => Mage::helper('MoedaDigital')->__('Sale')),
        );
    }
}