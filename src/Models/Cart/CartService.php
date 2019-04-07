<?php

namespace PedidosComidas\Models\Cart;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Store\Order\OrderService;
use PedidosComidas\Models\Store\Order\OrderEntity;

class CartService extends AbstractService {
	
	public function __construct() {
		parent::__construct();

		$this->orderService = new OrderService();
	}

	public function getUserOrder(int $userID) {
		$orders = $this->orderService->load([
			'author' => $userID,
			'status' => OrderEntity::ORDER_STATUS_CART
		]);

		if (empty($orders))
			return null;

		$order = array_shift($orders);

		return $order;
	}

	public function createCartOrder(int $userID, array $lineItems) {
		$order = [
			'author' => $userID,
			'status' => OrderEntity::ORDER_STATUS_CART,
			'line_items' => $lineItems
		];

		return $this->orderService->create($order);
	}

	public function updateCartOrder(OrderEntity $order, array $lineItems) {
		return $this->orderService->edit($order, ['line_items' => $lineItems]);
	}
}