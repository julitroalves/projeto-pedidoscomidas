<?php

namespace PedidosComidas\Models\Product;

use PedidosComidas\Models\AbstractEntity;

class ProductEntity extends AbstractEntity {
	public $id;
	public $title;
	public $description;
	public $author;
	public $price;
	public $created;
	public $updated;
	public $coverID = 0;

	public function __construct($title, $description, $author, $price, $created, $updated) {
		$this->title = $title;
		$this->description = $description;
		$this->author = $author;
		$this->price = $price;
		$this->created = $created;
		$this->updated = $updated;
	}

	public function getUrl() {
		return $this->getBaseUrl() . '/products/' . $this->id;
	}
}