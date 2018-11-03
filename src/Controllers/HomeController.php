<?php

namespace PedidosComidas\Controllers;

class HomeController {

	public function loadUsers() {
		$pdo = new \PDO("mysql:host=localhost;dbname=housecursos_pedidoscomidas", "root", "qwe123");

		$users = $pdo->query("SELECT * FROM users");

		return $users;
	}

	public function index($request, $response, $renderer) {
		$name = $request->query->get('name', 'Julio Alves');

		$users = $this->loadUsers();

		var_dump($users);

		$context = [
			'title' => "Home Dinâmica 100% melhorada!",
			'users' => $users,
			'name' => $name,
		];

		$content = $renderer->render("home.index", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function home($request, $response, $renderer) {
		$context = [
			'title' => "Home Dinâmica 100% melhorada!"
		];

		$content = $renderer->render("home.index", $context);

		$response->setContent($content);

		return $response->send();
	}
}