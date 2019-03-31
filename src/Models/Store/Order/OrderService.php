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

		if (!empty($formData['line_items'])) {
			$orderLineItems = $this->createLineItems($order, $formData['line_items']);

			$order->setItems($orderLineItems);
		}

		return $order;
	}

	public function edit(OrderEntity $order, array $formData) {
		$order->total = $formData['total'] ?? $order->total;

		$order->status = $formData['status'] ?? $order->status;
		
		$order->updated = date('Y-m-d H:i:s', time());

		$updated = $this->orderMapper->update($order);

		if (!$updated) {
			return FALSE;
		}

		if (!empty($formData['line_items'])) {
			$orderLineItems = $this->editLineItems($order, $formData['line_items']);

			$order->setItems($orderLineItems);
		}

		return $order;
	}

	public function delete(OrderEntity $order) {
		$this->orderMapper->delete($order);
	}

	public function createLineItems($order, array $line_items) {
		$lineItems = [];

		foreach ($line_items as $line_item) {
			$line_item['orderID'] = $order->id;

			$lineItemCreatedEntity = $this->orderLineItemService->create($line_item);

			$lineItems[$lineItemCreatedEntity->id] = $lineItemCreatedEntity;
		}

		return $lineItems;
	}

	public function editLineItems($order, array $form_line_items) {
		$lineItems = [];

		foreach ($form_line_items as $line_item) {
			$lineItem = $order->getItem($line_item['id']);

			$lineItems[$lineItem->id] = $this->orderLineItemService->edit($lineItem, $line_item);
		}

		return $lineItems;
	}

	public function deleteLineItem(OrderLineItemEntity $lineItem) {
		return $this->orderLineItemService->delete($lineItem);
	}
}