<?php
/**
 *
 * MoedaDigital 
 *
 **/
class MoedaDigital_Model_Source_ParcelasComJuros {

    public function toOptionArray() {
        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Desativado somente à vista)')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Até 02 parcelas com juros')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('Até 03 parcelas com juros')),
            array('value' => 4, 'label' => Mage::helper('adminhtml')->__('Até 04 parcelas com juros')),
            array('value' => 5, 'label' => Mage::helper('adminhtml')->__('Até 05 parcelas com juros')),
            array('value' => 6, 'label' => Mage::helper('adminhtml')->__('Até 06 parcelas com juros')),
            array('value' => 7, 'label' => Mage::helper('adminhtml')->__('Até 07 parcelas com juros')),
            array('value' => 8, 'label' => Mage::helper('adminhtml')->__('Até 08 parcelas com juros')),
            array('value' => 9, 'label' => Mage::helper('adminhtml')->__('Até 09 parcelas com juros')),
            array('value' => 10, 'label' => Mage::helper('adminhtml')->__('Até 10 parcelas com juros')),
            array('value' => 11, 'label' => Mage::helper('adminhtml')->__('Até 11 parcelas com juros')),
            array('value' => 12, 'label' => Mage::helper('adminhtml')->__('Até 12 parcelas com juros'))
        );
    }
}