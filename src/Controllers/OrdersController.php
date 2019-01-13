<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

use PedidosComidas\Models\Store\Order\OrderService;

class OrdersController extends AbstractController {

	private $orderService;

	public function __construct() {
		parent::__construct();
		
		$this->orderService = new OrderService();
	}

	public function index($request, $response, $renderer) {
		
		$orders = $this->orderService->load();

		$context = [
			'title' => "Listagem de Pedidos",
			'orders' => $orders,
		];

		$content = $renderer->render("orders/page.list", $context);

		$response->setContent($content);

		return $response->send();
	}
	
	public function getOne($request, $response, $renderer, $params = []) {

		$product = $this->orderService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => $product->title,
			'product' => $product,
		];

		$content = $renderer->render("orders/page.view", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreate($request, $response, $renderer) {
		$context = [
			'title' => 'Criar Pedido'
		];

		$content = $renderer->render('orders/page.create', $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreateSubmit($request, $response, $renderer) {
		$sessionStore = $this->injector->get('SessionStore');
		$user = $sessionStore->get('user');

		$formData = $request->request->all();

		$formData['author'] = $user['id'];
		$this->orderService->create($formData);

		$response = new RedirectResponse('/');
		
		return $response->send();
	}

	public function formEdit($request, $response, $renderer, $params = []) {

		$product = $this->orderService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Edição de Produto',
			'product' => $product
		];

		$response->setContent($renderer->render("orders/page.edit", $context));

		return $response->send();
	}

	public function formEditSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();


		$product = $this->orderService->findByID($formData['id']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$productUpdated = $this->orderService->edit($product, [
			'id' => $formData['id'],
			'title' => $formData['title'],
			'description' => $formData['description'],
			'price' => $formData['price'],
		]);


		if (!$productUpdated) {
			$context = ['Infelizmente não foi possível atualizar este produto.'];

			$response->setContent($renderer->render("page.error", $context));

			return $response->send();
		}

		$response = new RedirectResponse('/');
		
		return $response->send();
	}

	public function formDelete($request, $response, $renderer, $params = []) {

		$product = $this->orderService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Deletar Produto',
			'product' => $product,
		];

		$response->setContent($renderer->render("orders/page.delete", $context));

		return $response->send();
	}

	public function formDeleteSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();


		$product = $this->orderService->findByID($formData['id']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$this->orderService->delete($product);

		$response = new RedirectResponse('/');

		return $response->send();
	}
}