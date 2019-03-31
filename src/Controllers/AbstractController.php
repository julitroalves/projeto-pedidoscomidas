<?php

namespace PedidosComidas\Controllers;

use PedidosComidas\DI\Dependencies;

class AbstractController {
	protected $injector;

	public function __construct() {
		$this->injector = Dependencies::getContainer();
	}

	public function getInjector() {
		return $this->injector;
	}

	public function getService($name) {
		return $this->getInjector()->get($name);
	}

	public function getSessionStore() {
		return $this->getService('SessionStore');
	}

	public function getCurrentUser() {
		return $this->getSessionStore()->get('user');
	}

	public function getCurrentUserID() {
		return $this->getCurrentUser()['id'] ?? 0;
	}

	public function userIsLoggedIn() {
		return (boolean) $this->getCurrentUserID();
	}

	public function setFlashMessage($message) {
		$this->getSessionStore()->setFlash('message', $message);
	}

	public function getFlashMessage() {
		return $this->getSessionStore()->getFlash('message');
	}
}