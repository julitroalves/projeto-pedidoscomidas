<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\Database\PdoAdapter;
use PedidosComidas\Models\User\UserDataMapper;

class HomeController {

	public function createUser() {
		$pdo = new PdoAdapter("mysql:host=localhost;dbname=housecursos_pedidoscomidas", "root", "qwe123");

		$usersMapper = new UserDataMapper($pdo);

		$userCreated = $usersMapper->insert([
			'username' => 'housecursos',
			'password' => '123456',
			'email'    => 'contato@housecursos.com',
			'name'     => 'House Cursos da Silva Oliveira',
			'created'  => date('Y-m-d H:i:s', time()),
			'updated'  => date('Y-m-d H:i:s', time())
		]);

		return $userCreated;
	}

	public function loadUsers() {
		$pdo = new PdoAdapter("mysql:host=localhost;dbname=housecursos_pedidoscomidas", "root", "qwe123");

		$usersMapper = new UserDataMapper($pdo);

		$users = $usersMapper->findAll();

		return $users;
	}

	public function index($request, $response, $renderer) {
		$name = $request->query->get('name', 'Julio Alves');

		$this->createUser();
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