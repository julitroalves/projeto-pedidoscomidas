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

		$order = $this->orderService->findByID($params['{int}']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => "Pedido de N° {$order->id}",
			'order' => $order,
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
		$user = $this->getCurrentUser();

		$formData = $request->request->all();

		$formData['author'] = $user['id'] ?? 0;

		$this->orderService->create($formData);

		$this->setFlashMessage('Pedido criado com sucesso!');

		$response = new RedirectResponse('/');
		
		return $response->send();
	}

	public function formEdit($request, $response, $renderer, $params = []) {

		$order = $this->orderService->findByID($params['{int}']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Edição de Pedido',
			'order' => $order,
			'userID'	=> $this->getCurrentUserID(),
			'message' => $this->getFlashMessage()
		];

		$response->setContent($renderer->render("orders/page.edit", $context));

		return $response->send();
	}

	public function formEditSubmit($request, $response, $renderer, $params = []) {
		$userID = $this->getCurrentUser()['id'];

		$formData = $request->request->all();

		$order = $this->orderService->findByID($formData['id']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$orderUpdated = $this->orderService->edit($order, $formData);

		if (!$orderUpdated) {
			$context = ['Infelizmente não foi possível atualizar este pedido.'];

			$response->setContent($renderer->render("page.error", $context));

			return $response->send();
		}

		$this->setFlashMessage('O seu pedido foi atualizado com sucesso!');

		$response = new RedirectResponse("/user/{$userID}/orders/{$order->id}/edit");
		
		return $response->send();
	}

	public function formDelete($request, $response, $renderer, $params = []) {

		$order = $this->orderService->findByID($params['{int}']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Deletar Pedido',
			'order' => $order,
		];

		$response->setContent($renderer->render("orders/page.delete", $context));

		return $response->send();
	}

	public function formDeleteSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();

		$order = $this->orderService->findByID($formData['id']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$this->orderService->delete($order);

		$response = new RedirectResponse('/');

		return $response->send();
	}

	public function formDeleteOrderLineItemSubmit($request, $response, $renderer, $params = []) {
		$order = $this->orderService->findByID($params['{int}']);

		if (!$order) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}


		$userID = $this->getCurrentUserID();

		// if ($order->author != $userID) {
		// 	$response->setContent($renderer->render("page.not-found"));

		// 	return $response->send();
		// }

		$lineItem = $order->getItem($params['{something}']);

		// var_dump($lineItem); die;

		$this->orderService->deleteLineItem($lineItem);

		$response = new RedirectResponse("/user/{$userID}/orders/{$order->id}/edit");
		
		return $response->send();
	}
}