<?php

namespace PedidosComidas\Controllers;

class HomeController {
	public function index($request, $response) {

		// $response = new Response('Método Index sendo Executado!');
		$response->setContent('Método Index sendo Executado!');

		return $response->send();
	}

	public function home($request, $response) {
		$response->setContent('Método Home sendo Executado!');

		// $response = new Response('Método Home sendo Executado!');

		return $response->send();
	}
}