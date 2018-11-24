<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Models\Product\ProductService;

class ProductsController {

	public function index($request, $response, $renderer) {
		$productService = new ProductService();
		
		$products = $productService->load();

		$context = [
			'title' => "Listagem de Produtos",
			'products' => $products,
		];

		$content = $renderer->render("products.page", $context);

		$response->setContent($content);

		return $response->send();
	}
	
	public function getOne($request, $response, $renderer) {
		$productService = new ProductService();

		$path = explode('/', $request->getPathInfo());

		$product = $productService->findByID($path[2]);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => $product->title,
			'product' => $product,
		];

		$content = $renderer->render("product.page", $context);

		$response->setContent($content);

		return $response->send();
	}

}