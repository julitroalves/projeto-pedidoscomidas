<?php

namespace PedidosComidas\DI;

class Dependencies {
	public static $container;

	public static function getContainer() {
		return self::$container;
	}

	public static function run() {
		$injector = new Container();

		$injector->set('Symfony\Component\HttpFoundation\Request');
		$injector->set('Symfony\Component\HttpFoundation\Response');

		$injector->set('TemplateRenderer', 'PedidosComidas\Template\SimpleTemplate');

		$injector->set('DBService', 'PedidosComidas\Database\DBService');

		$injector->set('SessionStore', 'PedidosComidas\Services\Session\Session');

		self::$container = $injector;

		return $injector;
	}
}
