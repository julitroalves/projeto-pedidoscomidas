<?php

namespace PedidosComidas\Models\Store\OrderLineItem;

class OrderLineItemEntity {

	public const PRODUCT_TYPE = 1;
	public const SHIPPING_TYPE = 2;
	public const VIRTUAL_PRODUCT_TYPE = 2;

	public $id;

	public $orderID;

	public $productID;
	
	public $type;

	public $quantity = 1;

	public $price = 0;

	public $created;

	public function __construct($orderID, $productID, $price = 0, $quantity = 1, $type = PRODUCT_TYPE) {
		$this->orderID = $orderID;

		$this->productID = $productID;
		
		$this->price = $price;

		$this->quantity = $quantity;

		$this->type = $type;

		$this->created = date('Y-m-d H:i:s', time());
	}

	public function setOrderID(int $id) {
		$this->orderID = $id;
	}

	public function getOrderID() {
		return $this->orderID;
	}

	public function setProductID(int $id) {
		$this->productID = $id;
	}

	public function getProductID() {
		return $this->productID;
	}

	public function setQuantity(int $qtd) {
		$this->quantity = $qtd;
	}

	public function getQuantity() {
		return $this->quantity;
	}

	public function setType(string $type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function setPrice(int $price) {
		$this->price = $price;
	}

	public function getPrice() {
		return $this->price;
	}

	public function setCreated(int $created) {
		$this->created = $created;
	}

	public function getCreated() {
		return $this->created;
	}
}