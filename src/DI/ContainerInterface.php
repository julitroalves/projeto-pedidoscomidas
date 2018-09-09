<?php

namespace PedidosComidas\DI;

interface ContainerInterface {
	public function get($abstract, $params);

	public function set($abstract, $params);
	
	public function has($abstract);
}