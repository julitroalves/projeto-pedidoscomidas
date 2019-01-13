<?php

namespace PedidosComidas\Models\Store\Order;

use PedidosComidas\Models\AbstractDataMapper;

class OrderDataMapper extends AbstractDataMapper  {
	protected $entityTable = "orders";

	public function insert(OrderEntity $order) {
		$id = $this->databaseAdapter->insert($this->entityTable, [
			'status' => $order->status,
			'author' => $order->author,
			'total' => $order->total,
			'created' => $order->created,
			'updated' => $order->updated,
		]);

		$order->id = $id;

		return $id;
	}

	public function update(OrderEntity $order) {
		$affectedRows = $this->databaseAdapter->update($this->entityTable, [
			'status' => $order->status,
			'total' => $order->total,
			'updated' => $order->updated,
		], "id = {$order->id}");

		return $affectedRows;
	}

	public function delete(OrderEntity $order) {
		return $this->databaseAdapter->delete($this->entityTable, "id = {$order->id}");
	}

	protected function createEntity($row) {
		$order = new OrderEntity(
			$row['author'],
			$row['items'] ?? [],
			$row['created'],
			$row['updated']
		);

		if (isset($row['status'])) {
			$order->status = $row['status'];
		}

		if (isset($row['id'])) {
			$order->id = $row['id'];
		}

		return $order;
	}
}