<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use PedidosComidas\Models\User\UserService;
use PedidosComidas\Models\Store\Order\OrderService;

class UserController extends AbstractController {

	private $userService;
	private $orderService;

	public function __construct() {
		parent::__construct();

		$this->userService = new UserService();

		$this->orderService = new OrderService();
	}

	public function formCreate($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		$context = [
			'title' => 'Registrar Usuário',
			'message' => $sessionStore->getFlash('message'),
		];

		$content = $renderer->render("user/page.create", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreateSubmit($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		$formData = $request->request->all();

		try {
			$user = $this->userService->create($formData);

			$response = new RedirectResponse('/');
			
			return $response->send();
		} catch (\Exception $e) {
			$sessionStore->setFlash('message', $e->getMessage());

			$response = new RedirectResponse('/user/create');

			return $response->send();
		}
	}
	
	public function getOne($request, $response, $renderer, $params = []) {
		$user = $this->userService->findById($params['{int}']);

		if (!$user) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$orders = $this->orderService->load(['author' => $this->getCurrentUserID()]);

		$context = [
			'title' => "Perfil do Usuário {$user->username}",
			'user' => $user,
			'orders' => $orders
		];

		$content = $renderer->render("user/page.view", $context);

		$response = $response->setContent($content);

		return $response->send();
	}

	public function formEdit($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		$user = $this->userService->findById($params['{int}']);

		if (!$user) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => "Atualizar Usuário $user->username",
			'message' => $sessionStore->getFlash('message'),
			'user' => $user,
		];

		$content = $renderer->render("user/page.edit", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formEditSubmit($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		$formData = $request->request->all();

		$user = $this->userService->findById($formData['id']);

		if (!$user) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		try {

			$this->userService->edit($user, [
				'id' => $formData['id'],
				'username' => $formData['username'],
				'current_password' => $formData['current_password'],
				'password' => $formData['password'],
				'password2' => $formData['password2'],
				'email' => $formData['email'],
				'name' => $formData['name'],
			]);

			$response = new RedirectResponse("/user/{$user->id}");

			return $response->send();
		} catch (\Exception $e) {
			$sessionStore->setFlash('message', $e->getMessage());

			$response = new RedirectResponse("/user/{$user->id}/edit");

			return $response->send();
		}
	}

}