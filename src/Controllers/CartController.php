<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

use PedidosComidas\Models\Store\Order\OrderService;
use PedidosComidas\Models\Store\Order\OrderEntity;
use PedidosComidas\Models\Cart\CartService;
use PedidosComidas\Models\Product\ProductService;

class CartController extends AbstractController {

	private $orderService;

	function __construct() {
		parent::__construct();

		$this->orderService = new OrderService();
		$this->cartService = new CartService();
		$this->productService = new ProductService();
	}

	public function index($request, $response, $renderer, $params = []) {
		
		if (!$this->userIsLoggedIn()) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$order = $this->cartService->getUserOrder($this->getCurrentUserID());

		if (!$order) {
			$response->setContent($renderer->render("cart/page.empty"));

			return $response->send();
		}

		$context = [
			'title' => 'Carrinho de Compras',
			'order' => $order,
			'userID' => $this->getCurrentUserID(),
		];

		$content = $renderer->render("cart/page.list", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCartToCheckoutSubmit($request, $response, $renderer, $params = []) {
		
	}

	public function formCartAddProductSubmit($request, $response, $renderer, $params = []) {
		$productID = $params['{int}'];

		if (!$this->userIsLoggedIn()) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$product = $this->productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$order = $this->cartService->getUserOrder($this->getCurrentUserID());
		
		$linesItems = [
			['productID' => $productID, 'price' => $product->price, 'quantity' => 1]
		];

		if (!$order) {
			$order = $this->cartService->createCartOrder($this->getCurrentUserID(), $linesItems);

			$response = new RedirectResponse('/cart');
		
			return $response->send();
		}

		$order = $this->cartService->updateCartOrder($order, $linesItems);

		$response = new RedirectResponse('/cart');
		
		return $response->send();
	}
}