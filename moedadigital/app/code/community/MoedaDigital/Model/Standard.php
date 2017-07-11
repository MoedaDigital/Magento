<?php
/**
 *
 * MoedaDigital 
 *
 * */
class MoedaDigital_Model_Standard extends Mage_Payment_Model_Method_Abstract {
    const PAYMENT_TYPE_AUTH = 'AUTHORIZATION';
    const PAYMENT_TYPE_SALE = 'SALE';
    protected $_code = 'moedadigital_standard';
    protected $_formBlockType = 'moedadigital/standard_form';
    protected $_canUseInternal = false;
    protected $_canUseForMultishipping = false;
    protected $_canCapture = true;
    protected $_canUseForCreditRating = false;

    public function getSession() {
        return Mage::getSingleton('moedadigital/session');
    }

    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

    public function getQuote() {
        return $this->getCheckout()->getQuote();
    }

    public function getOrderPlaceRedirectUrl() {


        $checkout = $this->getCheckout();


        $MDNumCartao = $_POST["MDNumCartao"];
        $checkout->setMoedaDigitalNumCartao($MDNumCartao);
        
		$MDmonth = $_POST["MDmonth"];
        $checkout->setMoedaDigitalMes($MDmonth);

        $MDyear = $_POST["MDyear"];
        $checkout->setMoedaDigitalAno($MDyear);
		
        $MDCodSeguranca = $_POST["MDCodSeguranca"];
        $checkout->setMoedaDigitalCVV($MDCodSeguranca);
		        
		$MDCardHold = $_POST["MDCardHold"];
        $checkout->setMoedaDigitalNome($MDCardHold);

        return Mage::getUrl('moedadigital/standard/redirect', array('_secure' => true));
    }

    function formatNumber($number) {
        return sprintf('%.2f', (double) $number) * 100;
    }

	function getSoapUrl() {
			 $soapUrl = 'https://moeda.digital/Gateway.asmx?WSDL';
        return $soapUrl;
    }
	
    public function getIniciarPagamento() {

        $checkout = $this->getCheckout();
        $orderId = $this->getCheckout()->getLastOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);
		$order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, true);
				
        //$MD_MeioPagto = $checkout->getMoedaDigitalMeioPagto();
        //$MD_FormaPagto = $checkout->getMoedaDigitalFormaPagto();
        //$MD_ValorParcela = $checkout->getMoedaDigitalValorParcela();

        $MDNumCartao = $checkout->getMoedaDigitalNumCartao($MDNumCartao);
        $MDmonth = $checkout->getMoedaDigitalMes($MDmonth);
        $MDyear = $checkout->getMoedaDigitalAno($MDyear);
        $MDCodSeguranca = $checkout->getMoedaDigitalCVV($MDCodSeguranca);
        $MDCardHold = $checkout->getMoedaDigitalNome($MDCardHold);
		
		//$MD_CPF =  $order->getCustomerTaxvat();
		//$MD_Genero = $order->getCustomerGender();
		
		//if ($MD_Genero == 1)
        //{
        //    $MD_Genero = 'M';
        //}
        //else
        //{
		//	$MD_Genero = 'F';
        //}

        //$MD_DataNasc =  $order->getCustomerDob();

        $isOrderVirtual = $order->getIsVirtual();

        if ($isOrderVirtual == true)
        {
            $a = $order->getBillingAddress();
            $b = $order->getBillingAddress();
        }
        else
        {
            $a = $order->getShippingAddress();
            $b = $order->getBillingAddress();
        }

        $LojaChaveAcesso = $this->getConfigData('token');
        $LojaApp = $this->getConfigData('aplicacao');
        $cliente_ip = $order->getData('remote_ip');

        //if ($MD_FormaPagto == 1)
        //{
            $ValorTotal = $this->formatNumber($order->getGrandTotal());
            $ValorSemJuros = $this->formatNumber($order->getGrandTotal());
			$MD_ValorParcela = $this->formatNumber($order->getGrandTotal());
            $Juros = 0;
			$MD_FormaPagto = 1;
        //}
        //else
        //{
        //    $ValorTotal = ($MD_ValorParcela * $MD_FormaPagto);
        //    $ValorSemJuros = ($order->getGrandTotal());
        //    $Juros = $this->formatNumber($ValorTotal - $ValorSemJuros);
        //    $ValorTotal = $this->formatNumber($ValorTotal);
        //    $ValorSemJuros = $this->formatNumber($ValorSemJuros);
        //}

		
//<Genero>' . $MD_Genero . '</Genero>
//<CpfCnpj>' . $MD_CPF . '</CpfCnpj>

$PedidoXML = '<?xml version="1.0" encoding="utf-16"?>
<clsPedido xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<Cliente>
<Nome>' . $a->getFirstname() . '</Nome>
<Sobrenome>' . $a->getLastname() . '</Sobrenome>
<Genero>I</Genero>
<CpfCnpj>0000</CpfCnpj>
<Moeda>BRL</Moeda>
<Idioma>PT-BR</Idioma>
<IpCadastro>' . $cliente_ip . '</IpCadastro>
</Cliente>
<Endereco1>
<Endereco>' . $a->getStreet(1) . '</Endereco>
<Bairro>' . $a->getStreet(2) . '</Bairro>
<Cidade>' . $a->getCity() . '</Cidade>
<UF>' . $a->getRegionCode() . '</UF>
<CEP>' . trim(str_replace("-", "", $a->getPostcode())) . '</CEP>
<Pais>' . $a->getCountry() . '</Pais>
<Telefone>' . $a->getTelephone() . '</Telefone>
<Tipo>Entrega</Tipo>
</Endereco1>
<Endereco2>
<Endereco>' . $b->getStreet(1) . '</Endereco>
<Bairro>' . $b->getStreet(2) . '</Bairro>
<Cidade>' . $b->getCity() . '</Cidade>
<UF>' . $b->getRegionCode() . '</UF>
<CEP>' . trim(str_replace("-", "", $b->getPostcode())) . '</CEP>
<Pais>' . $b->getCountry() . '</Pais>
<Telefone>' . $b->getTelephone() . '</Telefone>
<Tipo>Cobranca</Tipo>
</Endereco2>
<Email1>
<Email>' . $order->getCustomerEmail() . '</Email>
</Email1>
<LojaChaveAcesso>' . $LojaChaveAcesso . '</LojaChaveAcesso>
<LojaApp>' . $LojaApp . '</LojaApp>
<LojaCanal>WEB</LojaCanal>
<MeiosdePagamento>' . $MD_MeioPagto . '</MeiosdePagamento>
<PedidoNumeroLoja>' . $order->getRealOrderId() . '</PedidoNumeroLoja>
<PedidoEmissao></PedidoEmissao>
<PedidoVencimento></PedidoVencimento>
<PedidoExpiracao></PedidoExpiracao>
<PedidoRecorrente>N</PedidoRecorrente>
<PedidoValor>' . $ValorTotal . '</PedidoValor>
<PedidoValorSemJuros>' . $ValorSemJuros . '</PedidoValorSemJuros>
<PedidoMulta>0</PedidoMulta>
<PedidoJuros>' . $Juros . '</PedidoJuros>
<PedidoItens>1</PedidoItens>
<PedidoParcelas>' . $MD_FormaPagto . '</PedidoParcelas>
<PedidoValorParcelas>' . $MD_ValorParcela . '</PedidoValorParcelas>
<PedidoFinanciador>1</PedidoFinanciador>

<PortadorCartao>'. $MDNumCartao .'</PortadorCartao>
<PortadorValidade>' . $MDmonth . '/' . $MDyear . '</PortadorValidade>
<PortadorCVV>'. $MDCodSeguranca .'</PortadorCVV>
<PortadorNome>'. $MDCardHold .'</PortadorNome>
   
</clsPedido>';




		
		

        $parametros = array('PedidoXML' => $PedidoXML);
		Mage::log("MoedaDigital - IniciarPagamento: <br />: " .  $PedidoXML);
		
		
		
		$soapUrl = $this->getSoapUrl();
        $soap = new SoapClient($soapUrl);
		
        $Result = $soap->IniciarPagamento($parametros);
        $comment = 'Pedido iniciado no MoedaDigital com o seguinte retorno: ';
        $comment .= '<br />NSU: ' . $Result->IniciarPagamentoResult->NSU . ' ';
        $comment .= '<br />Status: ' . $Result->IniciarPagamentoResult->PedidoStatus . ' ';
        $comment .= '<br />Mensagem: ' . $Result->IniciarPagamentoResult->Mensagem . ' ';
        $order->addStatusHistoryComment($comment, false);
		
		$comment = 'Detalhes da forma de pagamento: ';
		$comment .= '<br />Valor do pedido: R$ ' .  sprintf('%.2f', (double)($ValorSemJuros /100))  . ' ';
		$comment .= '<br />Meio de pagamento: ' . $MD_MeioPagto . ' ';
		$comment .= '<br />Quantidade de parcelas: ' . $MD_FormaPagto . ' parcela(s) ';
		$comment .= '<br />Valor da parcela: R$ ' .  sprintf('%.2f', (double)($MD_ValorParcela/100)) . ' ';
		$comment .= '<br />Valor total a ser pago: R$ ' .  sprintf('%.2f', (double)($ValorTotal/100)) . ' ';
		$order->addStatusHistoryComment($comment, true);

		$order->setState(Mage_Sales_Model_Order::STATE_NEW, false)->save();
		
        $order->save();
		$order = Mage::getModel('sales/order')->load($orderId);
		$order->sendNewOrderEmail();

        return $Result->IniciarPagamentoResult->Conteudo;
    }
}
