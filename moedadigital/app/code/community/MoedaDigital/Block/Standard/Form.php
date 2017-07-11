<?php
/**
 *
 * MoedaDigital 
 *
 **/
class MoedaDigital_Block_Standard_Form extends Mage_Payment_Block_Form {

    protected function _construct() {
        parent::_construct();
        $this->setTemplate('moedadigital/form/moedadigital.phtml');
    }
}
