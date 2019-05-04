<?php

namespace PedidosComidas\Models\Store\Checkout\Payment;

class CreditCardPayment extends PaymentAbstract implements PaymentInterface {
	protected $id = 'credit_card';
	protected $title = 'Cartão de Crédito';
	protected $description = 'Utilize um cartão de crédito Visa, MasterCard ou Elo.';

	public function getDetails() {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $this->description,
		];
	}

	public function buildForm() {
		return '
		<form method="POST" accept-charset="utf-8">
			<div>
				<label>Número do Cartão</label>
				<input type="text" name="card_number"/>
			</div>
		</form>';
	}

	public function process($dataForm) {
		return true;
	}
}