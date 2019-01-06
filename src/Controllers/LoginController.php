<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use PedidosComidas\Models\User\UserService;

class LoginController extends AbstractController {

	private $userService;

	public function __construct() {
		parent::__construct();

		$this->userService = new UserService();
	}

	public function formLogin($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		if ($sessionStore->get('user')) {
			$response = new RedirectResponse('/');

			return $response->send();
		}

		$context = [
			'title' => "Login",
			'message' => $sessionStore->getFlash('message')
		];

		$content = $renderer->render("user/page.login", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formLoginSubmit($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		$formData = $request->request->all();

		try {
			$userAuthenticated = $this->userService->login($formData);
	
			$response = new RedirectResponse('/');
			
			return $response->send();
		} catch (\Exception $e) {
			$sessionStore->setFlash('message', $e->getMessage());
		
			$response = new RedirectResponse('/user/login');
			
			return $response->send();
		}
	}

	public function logout($request, $response, $renderer, $params = []) {
		$sessionStore = $this->injector->get('SessionStore');

		$sessionStore->clear();

		$sessionStore->destroy();

		$response = new RedirectResponse('/user/login');
		
		return $response->send();
	}
}