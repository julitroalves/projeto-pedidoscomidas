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
		
		$context = [
			'title' => 'Pagamento',
			'order' => $order,
			'payments' => $payments,
			'message' => $this->getFlashMessage(),
		];

		$content = $renderer->render("checkout/payment/page.list", $context);

		$response->setContent($content);
		
		return $response->send();
	}
	
	public function formPaymentSubmit($request, $response, $renderer, $params = []) {
		if (!$this->userIsLoggedIn()) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$order = $this->cartService->getUserOrder($this->getCurrentUserID());

		if (!$order) {
			$response->setContent($renderer->render("cart/page.empty"));

			return $response->send();
		}

		$formData = $request->request->all();

		if (!isset($formData['payment_method']) || empty($formData['payment_method'])) {
			$this->setFlashMessage('Por favor, selecione algum método de pagamento.');

			$response = new RedirectResponse('/checkout/payment');

			return $response->send();			
		}

		$paymentID = $formData['payment_method'];
		$formPaymentID = "form_{$paymentID}";
		$paymentData = isset($formData[$formPaymentID]) ? $formData[$formPaymentID] : [];

		$paymentProcessResponse = $this->paymentService->process($formData['payment_method'], $paymentData);

		if (false === $paymentProcessResponse) {
			$this->setFlashMessage('O pagamento não existe.');

			$response = new RedirectResponse('/checkout/payment');

			return $response->send();
		}

		if (false === $paymentProcessResponse['status']) {
			$this->setFlashMessage('Infelizmente o seu pagamento foi rejeitado.');

			$response = new RedirectResponse('/checkout/payment');

			return $response->send();
		}

		$this->orderService->edit($order, ['status' => OrderEntity::ORDER_STATUS_COMPLETED]);

		$response = new RedirectResponse('/checkout/completed/' . $order->id);

		return $response->send();
	}

	public function completedPage($request, $response, $renderer, $params = []) {
		if (!$this->userIsLoggedIn()) {
			$response->setContent($renderer->render("page.not-authorized"));

			return $response->send();
		}

		$order = $this->orderService->findByID($params['{int}']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => "Parabéns, seu pedido N° {$order->id} foi finalizado com sucesso!",
			'order' => $order,
		];

		$content = $renderer->render("orders/page.view", $context);

		$response->setContent($content);

		return $response->send();
	}
	
}