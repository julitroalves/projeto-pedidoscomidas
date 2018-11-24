<?php

$routes = [
	['GET', '/', 'PedidosComidas\Controllers\HomeController'],
	['GET', '/home', 'PedidosComidas\Controllers\HomeController::home'],

	['GET', '/products', 'PedidosComidas\Controllers\ProductsController'],
	['GET', '/products/{int}', 'PedidosComidas\Controllers\ProductsController::getOne']
];

return $routes;