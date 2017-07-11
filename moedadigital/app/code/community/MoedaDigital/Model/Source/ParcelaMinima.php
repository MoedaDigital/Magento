<?php
/**
 *
 * MoedaDigital 
 *
 **/
class MoedaDigital_Model_Source_ParcelaMinima {
    public function toOptionArray() {
        return array(
            array('value' =>   0, 'label' => Mage::helper('adminhtml')->__('R$   0,00')),
            array('value' =>   5, 'label' => Mage::helper('adminhtml')->__('R$   5,00')),
            array('value' =>  10, 'label' => Mage::helper('adminhtml')->__('R$  10,00')),
            array('value' =>  15, 'label' => Mage::helper('adminhtml')->__('R$  15,00')),
            array('value' =>  20, 'label' => Mage::helper('adminhtml')->__('R$  20,00')),
            array('value' =>  25, 'label' => Mage::helper('adminhtml')->__('R$  25,00')),
            array('value' =>  30, 'label' => Mage::helper('adminhtml')->__('R$  30,00')),
            array('value' =>  35, 'label' => Mage::helper('adminhtml')->__('R$  35,00')),
            array('value' =>  40, 'label' => Mage::helper('adminhtml')->__('R$  40,00')),            
            array('value' =>  45, 'label' => Mage::helper('adminhtml')->__('R$  45,00')),
            array('value' =>  50, 'label' => Mage::helper('adminhtml')->__('R$  50,00')),
            array('value' =>  55, 'label' => Mage::helper('adminhtml')->__('R$  55,00')),
            array('value' =>  60, 'label' => Mage::helper('adminhtml')->__('R$  60,00')),
            array('value' =>  65, 'label' => Mage::helper('adminhtml')->__('R$  65,00')),
            array('value' =>  70, 'label' => Mage::helper('adminhtml')->__('R$  70,00')),
            array('value' =>  75, 'label' => Mage::helper('adminhtml')->__('R$  75,00')),
            array('value' =>  80, 'label' => Mage::helper('adminhtml')->__('R$  80,00')),
            array('value' =>  85, 'label' => Mage::helper('adminhtml')->__('R$  85,00')),
            array('value' =>  90, 'label' => Mage::helper('adminhtml')->__('R$  90,00')),
            array('value' =>  95, 'label' => Mage::helper('adminhtml')->__('R$  95,00')),            
            array('value' => 100, 'label' => Mage::helper('adminhtml')->__('R$ 100,00'))
        );
    }
}