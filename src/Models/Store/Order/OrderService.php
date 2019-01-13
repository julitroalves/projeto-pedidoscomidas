<?php

namespace PedidosComidas\Models\Store\Order;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Store\Order\OrderDataMapper;
use PedidosComidas\Models\Store\Order\OrderEntity;

class OrderService extends AbstractService {
	private $dbService;
	
	private $adapter;

	private $orderMapper;

	public function __construct() {
		parent::__construct();

		$this->dbService = $this->injector->get('DBService');

		$this->adapter = $this->dbService->getConnection();
		
		$this->orderMapper = new OrderDataMapper($this->adapter);
	}

	public function load(array $parameters = []) {
		$orders = $this->orderMapper->findAll($parameters);

		return $orders ?? [];
	}

	public function findByID($id) {
		$orders = $this->orderMapper->findAll(['id' => $id]);

		if (empty($orders))
			return null;

		$orders = array_shift($orders);

		return $orders;
	}

	public function create(array $formData) {
		$data = [
			'author' => $formData['author'],
			'status' => $formData['status'] ?? 0,
			'created'  => date('Y-m-d H:i:s', time()),
			'updated'  => NULL
		];

		$order = new OrderEntity(
			$data['author'],
			[],
			$data['created'],
			$data['updated']
		);
		
		$this->orderMapper->insert($order);

		return $order;
	}

	public function edit(OrderEntity $order, array $data) {
		$order->total = $data['total'] ?? $order->total;

		$order->status = $data['status'] ?? $order->status;
		
		$order->updated = date('Y-m-d H:i:s', time());

		$updated = $this->orderMapper->update($order);

		if (!$updated) {
			return FALSE;
		}

		return $order;
	}

	public function delete(OrderEntity $order) {
		return $this->orderMapper->delete($order);
	}
}