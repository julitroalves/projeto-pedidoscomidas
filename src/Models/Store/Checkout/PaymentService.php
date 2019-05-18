<?php

namespace PedidosComidas\Models\Store\Checkout;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Store\Checkout\PaymentManager;

class PaymentService extends AbstractService {
	private $paymentManager;

	public function __construct() {
		parent::__construct();

		$this->paymentManager = new PaymentManager();
	}

	public function load() {
		return $this->paymentManager->load();
	}

	public function process(string $paymentID, array $data = []) {
		return $this->paymentManager->process($paymentID, $data);
	}
}