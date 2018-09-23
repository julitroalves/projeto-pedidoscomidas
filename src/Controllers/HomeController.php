<?php

namespace PedidosComidas\Controllers;

class HomeController {

	public function index($request, $response, $renderer) {
		$name = $request->query->get('name', 'Julio Alves');

		$context = [
			'title' => "Home Dinâmica 100% melhorada!",
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