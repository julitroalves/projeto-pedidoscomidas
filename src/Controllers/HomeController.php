<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Models\User\UserService;
use PedidosComidas\Models\Product\ProductService;

class HomeController extends AbstractController {

	public function index($request, $response, $renderer) {
		$sessionStore = $this->injector->get('SessionStore');

		$productService = new ProductService();

		$name = $sessionStore->get('user')['name'] ?? 'Forasteiro';
		
		$products = $productService->load();

		$context = [
			'title' => "Home",
			'products' => $products,
			'name' => $name,
		];

		$content = $renderer->render("home.index", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function home($request, $response, $renderer) {
		$context = [
			'title' => "Home"
		];

		$content = $renderer->render("home.index", $context);

		$response->setContent($content);

		return $response->send();
	}
}
