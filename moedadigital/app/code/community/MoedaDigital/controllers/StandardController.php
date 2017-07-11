<?php
/**
 *
 * MoedaDigital 
 *
 **/
 class MoedaDigital_StandardController extends Mage_Core_Controller_Front_Action {

    protected $_order;

    public function getOrder() {
        if ($this->_order == null)
        {
            
        }
        return $this->_order;
    }

    public function getStandard() {
        return Mage::getSingleton('moedadigital/standard');
    }

    public function redirectAction() {
        $session = Mage::getSingleton('checkout/session');
        $session->setPaypalStandardQuoteId($session->getQuoteId());
        $this->getResponse()->setBody($this->getLayout()->createBlock('moedadigital/standard_redirect')->toHtml());
        $session->unsQuoteId();
    }
    
	/**
    * Retorno do status do pagamento feito pelo MoedaDigital
    */
    public function AprovacaoAction() {
	
	    if (!$this->getRequest()->isPost())
        {
			$PedidoID = $_GET['Pedido'];
			$Status = $_GET['Status'];
		}
		else
		{
			$PedidoID = $_POST['Pedido'];
			$Status = $_POST['Status'];
		}
		
		Mage::log("MoedaDigital - AprovacaoAction: PedidoID: " .  $PedidoID . " - Status: " . $Status);
		//?$Status=A096023
		if (substr($Status, 0, 1) == "A")
		{
			echo "<div style='font-size:13px; font-weight:bold; color:green; background-color:#eeeeee; text-align:center; margin:auto;"; 
			echo "margin-top:5px; margin-bottom:5px; padding:5px; width:60%; border:2px solid green'>";
			echo "Sua transação foi processada com sucesso<br />";
			echo  "Transação Número: " . substr($Status, 1);
		}
		else
		{
			echo "<div style='font-size:13px; font-weight:bold; color:red; background-color:#eeeeee; text-align:center; margin:auto;";
			echo "margin-top:5px; margin-bottom:5px; padding:5px; width:60%; border:2px solid red'>";
			echo  "Sua transação <b>não</b> foi aprovada, favor verificar os dados do cartão.";
		}
		echo  "<br /><br /><a href='/Index.php/customer/account'>Voltar</a>";
		echo  "</div>";
    }
	
    /**
     * Retorno do status do pagamento feito pelo MoedaDigital
     */
    public function RetornoAction() {
	
        $standard = $this->getStandard();
        # Se for um metodo $_GET
        if (!$this->getRequest()->isPost())
        {
			$PedidoID = $_GET['Pedido'];
		}
		else
		{
			$PedidoID = $_POST['Pedido'];
		}
		Mage::log("MoedaDigital - RetornoAction: PedidoID: " .  $PedidoID);
		
		//Verifica o Status no pedido via WebService por seguranca
		$soapUrl = $standard->getSoapUrl();
		$soap = new SoapClient($soapUrl);
		
		$lojaToken = $standard->getConfigData('token');
		$lojaApp = $standard->getConfigData('aplicacao');

		echo "lojaToken:" .  $lojaToken . "<br />";
		echo "lojaApp:" .  $lojaApp . "<br />";
		echo "PedidoID:" .  $PedidoID . "<br />";
		
		$array_consulta_pagamento = array(
		   "Loja" => $lojaToken,
		   "Aplicacao" => $lojaApp,
		   "Pedido" => $PedidoID    
		);

		$Result = $soap->ConsultaStatusPagamento($array_consulta_pagamento);

		$wsPedidoNumeroLoja = $Result->ConsultaStatusPagamentoResult->PedidoNumeroLoja;
		Mage::log("MoedaDigital - RetornoAction: wsPedidoNumeroLoja=" .  $wsPedidoNumeroLoja);
		$wsStatus = $Result->ConsultaStatusPagamentoResult->Status;
		Mage::log("MoedaDigital - RetornoAction: wsStatus=" .  $wsStatus);
		$wsModulo = $Result->ConsultaStatusPagamentoResult->Modulo;
		Mage::log("MoedaDigital - RetornoAction: wsModulo=" .  $wsModulo);
		$wsMeioPagamento = $Result->ConsultaStatusPagamentoResult->MeioPagamento;
		Mage::log("MoedaDigital - RetornoAction: wsMeioPagamento=" .  $wsMeioPagamento);
		$wsDataPagamento = $Result->ConsultaStatusPagamentoResult->DataPagamento;
		Mage::log("MoedaDigital - RetornoAction: wsDataPagamento=" .  $wsDataPagamento);
		$wsValorPago = $Result->ConsultaStatusPagamentoResult->ValorPago;
		Mage::log("MoedaDigital - RetornoAction: wsValorPago=" .  $wsValorPago);

		$salesOrder = Mage::getSingleton('sales/order');
		$order = $salesOrder->loadByIncrementId($wsPedidoNumeroLoja);

		if ($order->getId())
		{
		Mage::log("MoedaDigital - RetornoAction: Passo1!");
			  if (strtolower(trim($wsStatus)) == 'aprovado')
			{
				Mage::log("MoedaDigital - RetornoAction: Passo3!");
				$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save();
				$order->sendOrderUpdateEmail(true, $comment);
				Mage::log("MoedaDigital - RetornoAction: sendNewOrderEmail");
			}
			else
			{
				Mage::log("MoedaDigital - RetornoAction: Passo4!");
				$comment = $wsStatus;
				if (strtolower(trim($wsStatus)) == 'cancelado')
				{
					$order->cancel();
					$comment = 'Pedido cancelado por falta de pagamento - MoedaDigital';
					$changeTo = Mage_Sales_Model_Order::STATE_CANCELED;
					$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
				}
				if (strtolower(trim($wsStatus)) == 'negado')
				{
					$order->cancel();
					$comment = 'Pedido cancelado por falta de pagamento - MoedaDigital';
					$changeTo = Mage_Sales_Model_Order::STATE_CANCELED;
					$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
				}
				if (strtolower(trim($wsStatus)) == 'pendente')
				{
					$comment = 'Pedido aguardando confirmacao do pagamento - MoedaDigital';
					$changeTo = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
					$order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, true)->save();
				}
				if (in_array(strtolower($wsStatus), array('cancelado', 'pendente', 'fraude')))
				{
					$order->addStatusToHistory($changeTo, $comment, $notified = false);
					$order->save();
				}
				$order->sendOrderUpdateEmail(true, $comment);
			}
			
			echo "<br /><br />Retorno Processado com sucesso!";
			Mage::log("MoedaDigital - RetornoAction: Retorno Processado com sucesso");
		}
		Mage::log("MoedaDigital - RetornoAction: FIM!");
    }
}
    