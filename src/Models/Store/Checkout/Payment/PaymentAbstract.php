<?php

namespace PedidosComidas\Models\Store\Checkout\Payment;

class PaymentAbstract {
	protected $id;
	protected $title;
	protected $description;

	public function getID() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getDescription() {
		return $this->description;
	}

	public function __toString() {
		return $this->title;
	}
}