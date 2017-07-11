<?php
/**
 *
 * MoedaDigital 
 *
 **/
class MoedaDigital_Model_Source_ParcelasSemJuros {

    public function toOptionArray() {
        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Desativado Somente à vista)')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Até 02 parcelas sem juros')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('Até 03 parcelas sem juros')),
            array('value' => 4, 'label' => Mage::helper('adminhtml')->__('Até 04 parcelas sem juros')),
            array('value' => 5, 'label' => Mage::helper('adminhtml')->__('Até 05 parcelas sem juros')),
            array('value' => 6, 'label' => Mage::helper('adminhtml')->__('Até 06 parcelas sem juros')),
            array('value' => 7, 'label' => Mage::helper('adminhtml')->__('Até 07 parcelas sem juros')),
            array('value' => 8, 'label' => Mage::helper('adminhtml')->__('Até 08 parcelas sem juros')),
            array('value' => 9, 'label' => Mage::helper('adminhtml')->__('Até 09 parcelas sem juros')),
            array('value' => 10, 'label' => Mage::helper('adminhtml')->__('Até 10 parcelas sem juros')),
            array('value' => 11, 'label' => Mage::helper('adminhtml')->__('Até 11 parcelas sem juros')),
            array('value' => 12, 'label' => Mage::helper('adminhtml')->__('Até 12 parcelas sem juros'))
        );
    }
}