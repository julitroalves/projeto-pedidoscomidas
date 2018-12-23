<?php

namespace PedidosComidas\Models\Product;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Product\ProductDataMapper;
use PedidosComidas\Models\Product\ProductEntity;

class ProductService extends AbstractService {
	private $dbService;
	
	private $adapter;

	private $productMapper;

	public function __construct() {
		parent::__construct();

		$this->dbService = $this->injector->get('DBService');

		$this->adapter = $this->dbService->getConnection();
		
		$this->productMapper = new ProductDataMapper($this->adapter);
	}

	public function load(array $parameters = []) {
		$products = $this->productMapper->findAll($parameters);

		return $products;
	}

	public function findByID($id) {
		$products = $this->productMapper->findAll(['id' => $id]);

		if (empty($products))
			return null;

		$products = array_shift($products);

		return $products;
	}

	public function create(array $data) {
		$product = new ProductEntity(
			$data['title'],
			$data['description'],
			$data['author'],
			$data['price'],
			$data['created'],
			$data['updated']
		);
		
		$this->productMapper->insert($product);

		return $product;
	}

	public function edit(ProductEntity $product, array $data) {
		$product->title = $data['title'] ?? $product->title;

		$product->description = $data['description'] ?? $product->description;

		$product->price = $data['price'] ?? $product->price;

		$product->updated = date('Y-m-d H:i:s', time());

		$updated = $this->productMapper->update($product);

		if (!$updated) {
			return FALSE;
		}

		return $product;
	}

	public function delete(ProductEntity $product) {
		return $this->productMapper->delete($product);
	}
}