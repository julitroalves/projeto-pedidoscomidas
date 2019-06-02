<?php

namespace PedidosComidas\Models\Product;

use PedidosComidas\Models\AbstractService;
use PedidosComidas\Models\Product\ProductDataMapper;
use PedidosComidas\Models\Product\ProductEntity;
use PedidosComidas\Models\File\FileService;

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

		if (empty($products))
			return [];

		$fileService = new FileService([]);
		array_walk($products, function($product) use ($fileService) {
			$product->cover = $fileService->findByID($product->coverID);
		});

		return $products;
	}

	public function findByID($id) {
		$product = $this->productMapper->findById($id);

		if (empty($product))
			return null;

		$fileService = new FileService([]);
		$product->cover = $fileService->findByID($product->coverID);

		return $product;
	}

	public function create(array $formData) {
		$fileService = new FileService($_FILES);

		$file = $fileService->save('cover');

		$data = [
			'cover_id' => $file->id,
			'title' => $formData['title'],
			'description' => $formData['description'],
			'price' => $formData['price'],
			'author' => '1',
			'created'  => date('Y-m-d H:i:s', time()),
			'updated'  => NULL
		];

		$product = new ProductEntity(
			$data['title'],
			$data['description'],
			$data['author'],
			$data['price'],
			$data['created'],
			$data['updated']
		);

		$product->coverID = $data['cover_id'];
		
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