<?php

namespace PedidosComidas\Models\Store\Checkout\Payment;

class DepositPayment extends PaymentAbstract implements PaymentInterface {
	protected $id = 'bank_deposit';
	protected $title = 'Depósito Bancário';
	protected $description = 'Deposite em uma de nossas contas.';

	public function getDetails() {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $this->description,
		];
	}

	public function buildForm() {
		return '
			<div>
				<p>Deposite em uma das contas abaixo e nos envie o comprovante:</p>

				<p>Banco: Caixa - Agência: 97493-1 - Conta: 743823</p>
				<p>Banco: Banco do Brasil - Agência: 237-1 - Conta: 992-0</p>
			</div>
		';
	}

	public function process($dataForm) {
		return true;
	}
}