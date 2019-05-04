<?php

namespace PedidosComidas\Models\Store\Checkout\Payment;

class BilletPayment extends PaymentAbstract implements PaymentInterface {
	protected $id = 'billet';
	protected $title = 'Boleto Bancário';
	protected $description = 'Pagamentos com boleto levam até 2 dias para serem compensados.';

	public function getDetails() {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $this->description,
		];
	}

	public function buildForm() {
		return '';
	}

	public function process($dataForm) {
		return true;
	}
}