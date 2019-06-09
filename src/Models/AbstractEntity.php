<?php

namespace PedidosComidas\Models;

abstract class AbstractEntity {
	
	protected function getBaseUrl() {
		return 'http://' . $_SERVER['SERVER_NAME'];
	}
}