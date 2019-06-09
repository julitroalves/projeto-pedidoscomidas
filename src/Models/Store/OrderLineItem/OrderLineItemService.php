<?php

namespace PedidosComidas\Models\Store\OrderLineItem;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Store\OrderLineItem\OrderLineItemDataMapper;
use PedidosComidas\Models\Store\OrderLineItem\OrderLineItemEntity;
use PedidosComidas\Models\Product\ProductService;


class OrderLineItemService extends AbstractService {
	private $dbService;
	
	private $adapter;

	private $orderLineItemMapper;

	public function __construct() {
		parent::__construct();

		$this->dbService = $this->injector->get('DBService');

		$this->adapter = $this->dbService->getConnection();
		
		$this->orderLineItemMapper = new OrderLineItemDataMapper($this->adapter);

		$this->productService = new ProductService();
	}

	public function load(array $parameters = []) {
		$lineItems = $this->orderLineItemMapper->findAll($parameters);

		if (empty($lineItems))
			return [];

		array_walk($lineItems, function($item) {
			$productID = $item->getProductID();

			$product = $this->productService->findByID($productID);

			$item->setProduct($product);
		});

		return $lineItems ?? [];
	}

	public function findByID($id) {
		$lineItems = $this->orderLineItemMapper->findAll(['id' => $id]);

		if (empty($lineItems))
			return null;

		$lineItems = array_shift($lineItems);

		return $lineItems;
	}

	public function create(array $formData) {
		$data = [
			'orderID' => $formData['orderID'],
			'productID' => $formData['productID'],
			'price' => $formData['price'],
			'quantity' => $formData['quantity'],
			'type' => $formData['type'] ?? OrderLineItemEntity::PRODUCT_TYPE
		];

		$lineItem = new OrderLineItemEntity(
			$data['orderID'],
			$data['productID'],
			$data['price'],
			$data['quantity'],
			$data['type']
		);
		
		$this->orderLineItemMapper->insert($lineItem);

		return $lineItem;
	}

	public function edit(OrderLineItemEntity $lineItem, array $data) {
		$lineItem->quantity = $data['quantity'] ?? $lineItem->quantity;

		$lineItem->price = $data['price'] ?? $lineItem->price;

		$updated = $this->orderLineItemMapper->update($lineItem);

		if (!$updated) {
			return FALSE;
		}

		return $lineItem;
	}

	public function delete(OrderLineItemEntity $lineItem) {
		return $this->orderLineItemMapper->delete($lineItem);
	}
}