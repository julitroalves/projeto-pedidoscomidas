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
			<div>
				<label>Número do Cartão</label>
				<input type="text" name="form_credit_card[card_number]"/>
			</div>

			<div>
				<label>Data de Validade do Cartão</label>
				<input type="text" name="form_credit_card[card_date]"/>
			</div>

			<div>
				<label>Código de Segurança</label>
				<input type="text" name="form_credit_card[card_secure_code]"/>
			</div>
		';
	}

	public function process($dataForm) {
		return [
			'status' => false,
		];
	}
}