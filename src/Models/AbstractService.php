<?php

namespace PedidosComidas\Models;

use PedidosComidas\DI\Dependencies;

abstract class AbstractService {
	protected $injector;

	public function __construct() {
		$this->injector = Dependencies::getContainer();
	}

}