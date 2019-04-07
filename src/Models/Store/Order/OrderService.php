<?php

namespace PedidosComidas\Models\Store\Order;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Store\Order\OrderDataMapper;
use PedidosComidas\Models\Store\Order\OrderEntity;
use PedidosComidas\Models\Store\OrderLineItem\OrderLineItemService;
use PedidosComidas\Models\Store\OrderLineItem\OrderLineItemEntity;

class OrderService extends AbstractService {
	private $dbService;
	
	private $adapter;

	private $orderMapper;

	private $orderLineItemService;

	public function __construct() {
		parent::__construct();

		$this->dbService = $this->injector->get('DBService');

		$this->adapter = $this->dbService->getConnection();
		
		$this->orderMapper = new OrderDataMapper($this->adapter);

		$this->orderLineItemService = new OrderLineItemService();
	}

	public function load(array $parameters = []) {
		$orders = $this->orderMapper->findAll($parameters, ['field' => 'created']);

		array_walk($orders, function($order) {
			$order->setItems($this->orderLineItemService->load(['order_id' => $order->id]));
		});

		return $orders ?? [];
	}

	public function findByID($id) {
		$order = $this->orderMapper->findByID($id);

		if (empty($order))
			return null;

		$order->setItems($this->orderLineItemService->load(['order_id' => $order->id]));

		return $order;
	}

	public function create(array $formData) {
		$data = [
			'author' => $formData['author'],
			'status' => $formData['status'] ?? OrderEntity::ORDER_STATUS_CART,
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
		$order->status = isset($formData['status']) ? (int) $formData['status'] : $order->status;
		
		$order->updated = date('Y-m-d H:i:s', time());

		$updated = $this->orderMapper->update($order);

		if (!$updated) {
			return FALSE;
		}

		if (!empty($formData['line_items'])) {

			$toUpdateLineItems = array_filter($formData['line_items'], function($item) {
				return isset($item['id']);
			});

			if (!empty($toUpdateLineItems))
				$this->editLineItems($order, $toUpdateLineItems);

			$toCreateLineItems = array_filter($formData['line_items'], function($item) {
				return !isset($item['id']);
			});

			if (!empty($toCreateLineItems))
				$this->createLineItems($order, $toCreateLineItems);
		}

		return $order;
	}

	public function delete(OrderEntity $order) {
		$this->orderMapper->delete($order);
	}

	public function createLineItems($order, array $line_items) {
		$lineItems = [];

		foreach ($line_items as $line_item) {
			if (empty($line_item['productID'])) continue;

			$line_item['orderID'] = $order->id;

			$lineItemCreatedEntity = $this->orderLineItemService->create($line_item);

			$lineItems[$lineItemCreatedEntity->id] = $lineItemCreatedEntity;
		}

		return $lineItems;
	}

	public function editLineItems($order, array $form_line_items) {
		$lineItems = [];

		foreach ($form_line_items as $line_item) {
			$line_item = array_filter($line_item);

			$lineItem = $order->getItem($line_item['id']);

			$lineItems[$lineItem->id] = $this->orderLineItemService->edit($lineItem, $line_item);
		}

		return $lineItems;
	}

	public function deleteLineItem(OrderLineItemEntity $lineItem) {
		return $this->orderLineItemService->delete($lineItem);
	}
}