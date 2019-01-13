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
			$params = [];

			if (!$this->request->isMethod($route[0])) {
				continue;
			}

			$matches = $this->resolveDynamicUrl($route, $this->path);

			if (false === $matches && $this->path !== $route[1])
				continue;

			if ($matches && $this->path !== $matches['path']) {
				return $this->resolveController($route, $matches['params']);
			}

			if ($this->resolveController($route, $matches['params'])) {
				return;
			}
		}

		$message = 'O Controller não Existe';
		throw new \Exception($message, 404);
	}

	public function resolveController($route, $params) {
		$controllerStr = $route[2];

		$controllerPieces = explode('::', $controllerStr);

		if (sizeof($controllerPieces) == 1) {
			$controller = new $controllerPieces[0]();

			if (method_exists($controller, 'index')) {
				$controller->index($this->request, $this->response, $this->renderer, $params);

				return true;
			} else {
				$message = 'O método do Controller não Existe';
				throw new \Exception($message, 404);						
			}

			return true;
		}

		if (sizeof($controllerPieces) == 2) {
			$controller = new $controllerPieces[0]();

			$methodStr = $controllerPieces[1];

			if (method_exists($controller, $methodStr)) {
				$controller->$methodStr($this->request, $this->response, $this->renderer, $params);

				return true;
			}
			else {
				$message = 'O método do Controller não Existe';
				throw new \Exception($message, 404);
			}

			return true;
		}

		return false;
	}

	public function resolveDynamicUrl($route, $path) {
		$matches = [];

		$matched = preg_match_all('/\{[a-zA-Z]+\}/', $route[1], $matches);
		$matches = array_shift($matches);

		if (!$matched) {
			return false;
		}

		$pathPieces = explode('/', $path);
		$routePieces = explode('/', $route[1]);

		if (count($pathPieces) != count($routePieces))
			return false;

		// URL BROWSER -> /products/1
		// Routes.php  -> /products/{int}

		$resolvedMatchedValues = [];
		foreach ($routePieces as $key => $routePiece) {
			if (!isset($pathPieces[$key]))
				return false;

			if ($routePiece == $pathPieces[$key])
				continue;

			if (!in_array($routePiece, $matches))
				return false;

			// QUEM CHEGAR AQUI: É o grande Vencedor


			if ($this->resolveMatchedDynamicValue($routePiece, $pathPieces[$key])) {
				$resolvedMatchedValues[$routePiece] = $pathPieces[$key];
			} else {
				return false;
			}
		}

		if (!empty($resolvedMatchedValues)) {
			return [
				'path' => $path,
				'matches' => $matches,
				'params' => $resolvedMatchedValues
			];
		}

		return false;
	}

	public function resolveMatchedDynamicValue($routePiece, $pathPiece) {
		switch ($routePiece) {
			case '{int}':
				return intval($pathPiece);
				
				break;
			
			case '{string}':
				return is_string($pathPiece);
				break;

			case '{something}':
				return is_string($pathPiece) || is_int($pathPiece);

				break;
		}

		return false;
	}
}