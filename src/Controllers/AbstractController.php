<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\DI\Dependencies;

class AbstractController {
	protected $injector;

	public function __construct() {
		$this->injector = Dependencies::getContainer();
	}
}