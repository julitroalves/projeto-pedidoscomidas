<?php

$routes = [

	// Home
	['GET', '/', 'PedidosComidas\Controllers\HomeController'],
	['GET', '/home', 'PedidosComidas\Controllers\HomeController::home'],

	// Login
	['GET', '/user/login', 'PedidosComidas\Controllers\LoginController::formLogin'],
	['POST', '/user/login', 'PedidosComidas\Controllers\LoginController::formLoginSubmit'],
	['GET', '/user/logout', 'PedidosComidas\Controllers\LoginController::logout'],

	// Users
	['GET', '/user/register', 'PedidosComidas\Controllers\UserController::formCreate'],
	['GET', '/user/create', 'PedidosComidas\Controllers\UserController::formCreate'],
	['POST', '/user/create', 'PedidosComidas\Controllers\UserController::formCreateSubmit'],
	['GET', '/user/{int}', 'PedidosComidas\Controllers\UserController::getOne'],
	['GET', '/user/{int}/edit', 'PedidosComidas\Controllers\UserController::formEdit'],
	['POST', '/user/{int}/edit', 'PedidosComidas\Controllers\UserController::formEditSubmit'],

	// Products
	['GET', '/products', 'PedidosComidas\Controllers\ProductsController'],
	['GET', '/products/{int}', 'PedidosComidas\Controllers\ProductsController::getOne'],
	['GET', '/products/create', 'PedidosComidas\Controllers\ProductsController::formCreate'],
	['POST', '/products/create', 'PedidosComidas\Controllers\ProductsController::formCreateSubmit'],
	['GET', '/products/{int}/edit', 'PedidosComidas\Controllers\ProductsController::formEdit'],
	['POST', '/products/{int}/edit', 'PedidosComidas\Controllers\ProductsController::formEditSubmit'],
	['GET', '/products/{int}/delete', 'PedidosComidas\Controllers\ProductsController::formDelete'],
	['POST', '/products/{int}/delete', 'PedidosComidas\Controllers\ProductsController::formDeleteSubmit'],

	// Orders
	['GET', '/user/{int}/orders', 'PedidosComidas\Controllers\OrdersController'],
	['GET', '/user/{int}/orders/{int}', 'PedidosComidas\Controllers\OrdersController::getOne'],
	
	['GET', '/user/{int}/orders/create', 'PedidosComidas\Controllers\OrdersController::formCreate'],
	['POST', '/user/{int}/orders/create', 'PedidosComidas\Controllers\OrdersController::formCreateSubmit'],

	['GET', '/user/{int}/orders/{int}/edit', 'PedidosComidas\Controllers\OrdersController::formEdit'],
	['POST', '/user/{int}/orders/{int}/edit', 'PedidosComidas\Controllers\OrdersController::formEditSubmit'],
	['GET', '/user/{int}/orders/{int}/delete', 'PedidosComidas\Controllers\OrdersController::formDelete'],
	['POST', '/user/{int}/orders/{int}/delete', 'PedidosComidas\Controllers\OrdersController::formDeleteSubmit'],
	
	['GET', '/user/{int}/orders/{int}/items/{something}/delete', 'PedidosComidas\Controllers\OrdersController::formDeleteOrderLineItemSubmit'],


	['GET', '/cart', 'PedidosComidas\Controllers\CartController'],
	['POST', '/cart', 'PedidosComidas\Controllers\CartController::formCartToCheckoutSubmit'],
	['POST', '/cart/add/{int}', 'PedidosComidas\Controllers\CartController::formCartAddProductSubmit'],
	['GET', '/cart/delete/{int}', 'PedidosComidas\Controllers\CartController::formCartDeleteProductSubmit'],

	['GET', '/checkout/payment', 'PedidosComidas\Controllers\CheckoutController::formPayment'],
	['POST', '/checkout/payment', 'PedidosComidas\Controllers\CheckoutController::formPaymentSubmit'],
	['GET', '/checkout/completed/{int}', 'PedidosComidas\Controllers\CheckoutController::completedPage'],


];

return $routes;