<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Models\Store\Order\OrderService;
use PedidosComidas\Models\Store\Order\OrderEntity;

class CartController extends AbstractController {

	private $orderService;

	function __construct() {
		parent::__construct();

		$this->orderService = new OrderService();
	}

	public function index($request, $response, $renderer, $params = []) {
		
		if (!$this->userIsLoggedIn()) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$orders = $this->orderService->load([
			'author' => $this->getCurrentUserID(),
			'status' => OrderEntity::ORDER_STATUS_CART
		]);

		$order = array_shift($orders);

		if (!$order) {
			$response->setContent($renderer->render("cart/page.empty"));

			return $response->send();
		}

		$context = [
			'title' => 'Carrinho de Compras',
			'order' => $order
		];

		$content = $renderer->render("cart/page.list", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCartSubmit($request, $response, $renderer, $params = []) {

	}

}