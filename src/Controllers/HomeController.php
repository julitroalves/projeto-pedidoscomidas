<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Database\PdoAdapter;

class HomeController {

	public function loadUsers() {
		$pdo = new PdoAdapter('mysql:host=localhost;dbname=housecursos_pedidoscomidas', 'root', 'qwe123');

		return $pdo->select("users")->fetchAll(\PDO::FETCH_OBJ);
	}

	public function index($request, $response, $renderer) {
		$name = $request->query->get('name', 'Julio Alves');

		$users = $this->loadUsers();

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