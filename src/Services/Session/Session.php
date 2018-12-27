<?php

namespace PedidosComidas\Services\Session;

class Session implements SessionInterface {

	static $initialized = false;

	public function __construct() {
		$this->initialize();
	}

	public function initialize() {
		if (static::$initialized) {
			return;
		}

		static::$initialized = true;

		session_start();
	}

	public function refresh() {
		$this->initialize();

		session_start();

		session_regenerate_id(true);

		session_write_close();
	}

	public function has(string $name) {
		$this->initialize();

		if (!array_key_exists($name, $_SESSION))
			return false;

		return true;
	}
	
	public function set(string $name, $value) {
		$this->initialize();

		$_SESSION[$name] = $value;
	}

	public function get(string $name) {
		$this->initialize();

		if (!$this->has($name))
			return false;
		
		return $_SESSION[$name];
	}

	public function delete(string $name) {
		$this->initialize();
		
		if (!$this->has($name))
			return false;

		unset($_SESSION[$name]);

		return true;
	}

	public function getAll() {
		$this->initialize();

		return $_SESSION;
	}

	public function clear() {
		$this->initialize();

		$_SESSION = [];
	}

	public function destroy() {
		$this->initialize();

		session_destroy();
	}

	public function getFlashKey(string $name) {
		return "_fs_{$name}";
	}

	public function setFlash(string $name, $value) {
		$flashKey = $this->getFlashKey($name);

		$this->set($flashKey, $value);
	}

	public function getFlash(string $name) {
		$flashKey = $this->getFlashKey($name);

		$flashValue = $this->get($flashKey);

		$this->delete($flashKey);

		return $flashValue;
	}
}