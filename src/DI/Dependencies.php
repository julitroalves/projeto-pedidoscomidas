<?php

namespace PedidosComidas\DI;

class Dependencies {
	public static function run() {
		$injector = new Container();

		$injector->set('Symfony\Component\HttpFoundation\Request');
		$injector->set('Symfony\Component\HttpFoundation\Response');

		return $injector;
	}
}
