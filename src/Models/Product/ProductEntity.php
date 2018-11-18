<?php

namespace PedidosComidas\Models\Product;

class ProductEntity {
	public $id;
	public $title;
	public $description;
	public $author;
	public $price;
	public $created;
	public $updated;

	public function __construct($title, $description, $author, $price, $created, $updated) {
		$this->title = $title;
		$this->description = $description;
		$this->author = $author;
		$this->price = $price;
		$this->created = $created;
		$this->updated = $updated;
	}
}