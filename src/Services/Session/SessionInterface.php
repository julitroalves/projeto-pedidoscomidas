<?php

namespace PedidosComidas\Services\Session;

interface SessionInterface {

	public function initialize();

	public function refresh();

	public function set(string $name, $value);
	
	public function get(string $name);

	public function delete(string $name);
	
	public function getAll();

	public function clear();
}