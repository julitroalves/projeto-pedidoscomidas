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

	public function getCartItemsQuantity(int $userID) {
		$order = $this->getUserOrder($userID);

		if (empty($order))
			return 0;

		return count($order->getItems());
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

	public function deleteItemByProductID(OrderEntity $order, array $productIDS) {
		$lineItems = $order->getItems();

		foreach ($lineItems as $key => $lineItem) {
			if (in_array($lineItem->getProductID(), $productIDS)) {
				$this->orderService->deleteLineItem($lineItem);
			}
		}
	}
}