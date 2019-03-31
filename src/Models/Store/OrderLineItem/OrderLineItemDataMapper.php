<?php

namespace PedidosComidas\Models\Store\OrderLineItem;

use PedidosComidas\Models\AbstractDataMapper;

class OrderLineItemDataMapper extends AbstractDataMapper  {
	protected $entityTable = "orders_line_items";

	public function insert(OrderLineItemEntity $lineItem) {
		$id = $this->databaseAdapter->insert($this->entityTable, [
			'order_id' => $lineItem->orderID,
			'product_id' => $lineItem->productID,
			'type' => $lineItem->type,
			'quantity' => $lineItem->quantity,
			'price' => $lineItem->price,
			'created' => $lineItem->created,
		]);

		$lineItem->id = $id;

		return $id;
	}

	public function update(OrderLineItemEntity $lineItem) {
		$affectedRows = $this->databaseAdapter->update($this->entityTable, [
			'quantity' => $lineItem->quantity,
			'price' => $lineItem->price,
		], "id = {$lineItem->id}");

		return $affectedRows;
	}

	public function delete(OrderLineItemEntity $lineItem) {
		return $this->databaseAdapter->delete($this->entityTable, "id = {$lineItem->id}");
	}

	protected function createEntity($row) {
		$lineItem = new OrderLineItemEntity(
			$row['orderID'],
			$row['productID'],
			$row['price'],
			$row['quantity'],
			$row['type']
		);

		if (isset($row['id'])) {
			$lineItem->id = $row['id'];
		}

		return $lineItem;
	}
}