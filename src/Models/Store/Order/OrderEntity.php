<?php

namespace PedidosComidas\Models\Store\Order;

class OrderEntity {
	public $id;
	public $author;
	public $items;
	public $total = 0;
	public $status = 0;
	public $created;
	public $updated;

	public function __construct($author, $items = [], $created, $updated) {
		$this->author = $author;
		$this->items = $items;
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

	public function setItems(array $items) {
		$this->items = $items;
	}

	public function getItems() {
		return $this->items;
	}
}