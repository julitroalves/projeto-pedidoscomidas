<?php

namespace PedidosComidas\Router;

class RouterManager {
	private $request;
	
	private $response;
	
	private $renderer;

	function __construct($request, $response, $renderer) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;

		$this->path = $this->request->getPathInfo();

		$this->run();
	}

	private function run() {
		$routes = include('Routes.php');

		foreach ($routes as $route) {
			if ($this->path == $route[1]) {
				$controllerStr = $route[2];

				$controllerPieces = explode('::', $controllerStr);

				if (sizeof($controllerPieces) == 1) {
					$controller = new $controllerPieces[0]();

					if (method_exists($controller, 'index')) {
						$controller->index($this->request, $this->response, $this->renderer);
					} else {
						$message = 'O método do Controller não Existe';
						throw new \Exception($message, 404);						
					}

					return;
				}

				if (sizeof($controllerPieces) == 2) {
					$controller = new $controllerPieces[0]();

					$methodStr = $controllerPieces[1];

					if (method_exists($controller, $methodStr))
						$controller->$methodStr($this->request, $this->response, $this->renderer);
					else {
						$message = 'O método do Controller não Existe';
						throw new \Exception($message, 404);
					}

					return;
				}
			}
		}

		$message = 'O Controller não Existe';
		throw new \Exception($message, 404);
	}
}