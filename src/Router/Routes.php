<?php

$routes = [
	['GET', '/', 'PedidosComidas\Controllers\HomeController'],
	['GET', '/home', 'PedidosComidas\Controllers\HomeController::home'],
];

return $routes;