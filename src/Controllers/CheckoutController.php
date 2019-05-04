<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

use PedidosComidas\Models\Store\Order\OrderService;
use PedidosComidas\Models\Store\Order\OrderEntity;
use PedidosComidas\Models\Cart\CartService;
use PedidosComidas\Models\Product\ProductService;
use PedidosComidas\Models\Store\Checkout\PaymentService;

class CheckoutController extends AbstractController {

	function __construct() {
		parent::__construct();

		$this->orderService = new OrderService();
		$this->cartService = new CartService();
		$this->productService = new ProductService();
		$this->paymentService = new PaymentService();
	}

	public function formPayment($request, $response, $renderer, $params = []) {
		if (!$this->userIsLoggedIn()) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$order = $this->cartService->getUserOrder($this->getCurrentUserID());

		if (!$order) {
			$response->setContent($renderer->render("cart/page.empty"));

			return $response->send();
		}

		$payments = $this->paymentService->load();
		var_dump($payments);
		
		$context = [
			'title' => 'Pagamento',
			'order' => $order,
			'payments' => $payments
		];

		$content = $renderer->render("checkout/payment/page.list", $context);

		$response->setContent($content);
		
		return $response->send();
	}
	
}