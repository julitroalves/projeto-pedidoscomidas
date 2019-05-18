<?php

namespace PedidosComidas\Models\Store\Checkout;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Store\Checkout\Payment\PaymentInterface;
use PedidosComidas\Models\Store\Checkout\Payment\BilletPayment;
use PedidosComidas\Models\Store\Checkout\Payment\CreditCardPayment;
use PedidosComidas\Models\Store\Checkout\Payment\DepositPayment;

class PaymentManager extends AbstractService {
		
	private $payments = [];

	public function __construct() {
		parent::__construct();

		$this->setup();
	}

	public function setup() {
		$this->add(new BilletPayment());
		$this->add(new CreditCardPayment());
		$this->add(new DepositPayment());
	}

	public function load() {
		return $this->payments;
	}

	public function add(PaymentInterface $payment) {
		$this->payments[$payment->getID()] = $payment;
	}

	public function process(string $paymentID, array $data = []) {
		if (!isset($this->payments[$paymentID])) {
			return false;
		}

		return $this->payments[$paymentID]->process($data);
	}
}