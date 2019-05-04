<?php

namespace PedidosComidas\Models\Store\Checkout\Payment;

interface PaymentInterface {
	public function getDetails();
	
	public function buildForm();

	public function process($dataForm);
}