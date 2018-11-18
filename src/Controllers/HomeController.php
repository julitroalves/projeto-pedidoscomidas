<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Models\User\UserService;
use PedidosComidas\Models\Product\ProductService;

class HomeController {

	public function index($request, $response, $renderer) {
		$productService = new ProductService();

		$name = $request->query->get('name', 'Julio Alves');

		$productService->create([
			'title' => 'Baião de dois com queijo',
			'description' => 'Baião de dois arretado muito gostoso!',
			'price' => '10',
			'author' => '1',
			'created'  => date('Y-m-d H:i:s', time()),
			'updated'  => date('Y-m-d H:i:s', time())
		]);
		
		$products = $productService->load();

		$context = [
			'title' => "Home Dinâmica 100% melhorada!",
			'products' => $products,
			'name' => $name,
		];

		$content = $renderer->render("home.index", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function home($request, $response, $renderer) {
		$context = [
			'title' => "Home Dinâmica 100% melhorada!"
		];

		$content = $renderer->render("home.index", $context);

		$response->setContent($content);

		return $response->send();
	}
}