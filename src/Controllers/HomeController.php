<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Models\User\UserService;
use PedidosComidas\Models\Product\ProductService;

class HomeController extends AbstractController {

	public function index($request, $response, $renderer) {
		$sessionStore = $this->getSessionStore();

		$productService = new ProductService();

		$user = $this->getCurrentUser();
		$name = $user['name'] ?? 'Forasteiro';
		
		$products = $productService->load();

		$context = [
			'title' => "Home",
			'products' => $products,
			'name' => $name,
			'message' => $this->getFlashMessage(),
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
