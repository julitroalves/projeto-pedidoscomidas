<?php

namespace PedidosComidas\Models\Store\Order;

class OrderEntity {

	public const ORDER_STATUS_CART = 1;
	public const ORDER_STATUS_WAITING_PAYMENT = 2;
	public const ORDER_STATUS_COMPLETED = 3;
	public const ORDER_STATUS_PAYMENT_APPROVED = 4;

	public $id;
	public $author;
	public $items;
	public $total = 0;
	public $status;
	public $created;
	public $updated;

	public function __construct($author, $items = [], $created, $updated) {
		$this->author = $author;
		$this->items = $items;
		$this->status = self::ORDER_STATUS_CART;
		$this->created = $created;
		$this->updated = $updated;

	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setItem($item) {
		$this->items[$item->id] = $item;
	}

	public function getItem($id) {
		return $this->items[$id] ?? null;
	}

	public function setItems(array $items) {
		$this->items = [];

		foreach ($items as $item) {
			$this->items[$item->id] = $item;
		}

		return $this->items;
	}

	public function getItems() {
		return $this->items;
	}
}