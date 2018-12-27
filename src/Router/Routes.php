<?php

$routes = [
	['GET', '/', 'PedidosComidas\Controllers\HomeController'],
	['GET', '/home', 'PedidosComidas\Controllers\HomeController::home'],

	['GET', '/user/login', 'PedidosComidas\Controllers\LoginController::formLogin'],
	['POST', '/user/login', 'PedidosComidas\Controllers\LoginController::formLoginSubmit'],

	['GET', '/products', 'PedidosComidas\Controllers\ProductsController'],
	['GET', '/products/{int}', 'PedidosComidas\Controllers\ProductsController::getOne'],
	['GET', '/products/create', 'PedidosComidas\Controllers\ProductsController::formCreate'],
	['POST', '/products/create', 'PedidosComidas\Controllers\ProductsController::formCreateSubmit'],
	['GET', '/products/{int}/edit', 'PedidosComidas\Controllers\ProductsController::formEdit'],
	['POST', '/products/{int}/edit', 'PedidosComidas\Controllers\ProductsController::formEditSubmit'],
	['GET', '/products/{int}/delete', 'PedidosComidas\Controllers\ProductsController::formDelete'],
	['POST', '/products/{int}/delete', 'PedidosComidas\Controllers\ProductsController::formDeleteSubmit'],
];

return $routes;