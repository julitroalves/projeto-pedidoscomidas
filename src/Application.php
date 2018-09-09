<?php

namespace PedidosComidas;

use \PedidosComidas\Router\RouterManager;
use \PedidosComidas\DI\Dependencies;

class Application {
	public static $injector;

	public static $request;
	
	public static $response;
	
	public static $routerManager;

	public static function run() {
		self::$injector = Dependencies::run();

		self::$request = self::$injector->get('Symfony\Component\HttpFoundation\Request');

		self::$response = self::$injector->get('Symfony\Component\HttpFoundation\Response');

		$request = self::$request::createFromGlobals();
		self::$routerManager = new RouterManager($request, self::$response);
	}
}