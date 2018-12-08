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

	public function edit(array $data) {
		$product = new ProductEntity(
			$data['title'],
			$data['description'],
			$data['author'],
			$data['price'],
			$data['created'],
			$data['updated']
		);

		$product->id = $data['id'];

		$this->productMapper->update($product);

		return $product;
	}
}