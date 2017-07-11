<?php
/**
 *
 * MoedaDigital 
 *
 **/
class MoedaDigital_Block_Standard_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        $standard = Mage::getModel('moedadigital/standard');

        $htmlMD =$standard->getIniciarPagamento();
		
		Mage::log("MoedaDigital - Redirect: <br />: " .  $htmlMD);
					
        $html = '<html>';
		$html = '<header>';
		$html.= '<script type="text/javascript" src="https://moeda.digital/Checkout/js/MoedaDigital.js"></script>';
		$html = '<header>';
		$html.= '<body>';
        $html.= $htmlMD;
		$html.= '<br /><br /><a href=/Index.php/customer/account>Voltar</a>';
        $html.= '</body></html>';
        return $html;
    }
}
