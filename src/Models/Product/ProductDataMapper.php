<?php

namespace PedidosComidas\Models\Product;

use PedidosComidas\Models\AbstractDataMapper;

class ProductDataMapper extends AbstractDataMapper  {
	protected $entityTable = "product";

	public function insert(ProductEntity $product) {
		$id = $this->databaseAdapter->insert($this->entityTable, [
			'title' => $product->title,
			'description' => $product->description,
			'price' => $product->price,
			'author' => $product->author,
			'created' => $product->created,
			'updated' => $product->updated,
			'cover_id' => $product->coverID,
		]);

		$product->id = $id;

		return $id;
	}

	public function update(ProductEntity $product) {
		$affectedRows = $this->databaseAdapter->update($this->entityTable, [
			'title' => $product->title,
			'description' => $product->description,
			'price' => $product->price,
			'updated' => $product->updated,
		], "id = {$product->id}");

		return $affectedRows;
	}

	public function delete(ProductEntity $product) {
		return $this->databaseAdapter->delete($this->entityTable, "id = {$product->id}");
	}

	protected function createEntity($row) {
		$product = new ProductEntity(
			$row['title'],
			$row['description'],
			$row['author'],
			$row['price'],
			$row['created'],
			$row['updated']
		);

		if (isset($row['cover_id'])) {
			$product->coverID = $row['cover_id'];
		}

		if (isset($row['id'])) {
			$product->id = $row['id'];
		}

		return $product;
	}
}