<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController {

	
	public function formLogin($request, $response, $renderer, $params = []) {
		$context = [
			'title' => "Login",
		];

		$content = $renderer->render("user/login.page", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formLoginSubmit($request, $response, $renderer, $params = []) {
		$user = [
			'name' => 'Julio Admin',
			'username' => 'admin',
			'password' => 'admin',
		];

		$formData = $request->request->all();

		if ($formData['username'] !== $user['username']) {
			$response = new RedirectResponse('/');
			
			return $response->send();
		}

		if ($formData['password'] !== $user['password']) {
			$response = new RedirectResponse('/');
			
			return $response->send();
		}

		session_start();

		$_SESSION['user'] = $user;

		$response = new RedirectResponse('/');
		
		return $response->send();
	}
}