<?php

namespace PedidosComidas\DI;

class Container implements ContainerInterface {
	protected $instances = [];

	public function set($abstract, $concrete = NULL) {
		if ($concrete === NULL) {
			$concrete = $abstract;
		}

		$this->instances[$abstract] = $concrete;
	}

	public function get($abstract, $parameters = []) {
		if (!isset($this->instances[$abstract])) {
			$this->set($abstract);
		}

		return $this->resolve($this->instances[$abstract], $parameters);
	}

	public function resolve($concrete, $parameters) {
		if ($concrete instanceof \Closure) {
			return $concrete($this, $parameters);
		}

		if (!class_exists($concrete)) {
			$message = "The class {$concrete} not exists";
			throw new \Exception($message);
		}

		$reflector = new \ReflectionClass($concrete);

		if (!$reflector->isInstantiable()) {
			$message = "The class {$concrete} is not instantiable";
			throw new \Exception($message);
		}

		$constructor = $reflector->getConstructor();

		if (is_null($constructor)) {
			return $reflector->newInstance();
		}

		if (empty($parameters)) {
			$parameters = $constructor->getParameters();
			$dependencies = $this->getDependencies($parameters);
		}
		else {
			$dependencies = $parameters;
		}

		return $reflector->newInstanceArgs($dependencies);
	}

	public function getDependencies($parameters) {
		$dependencies = [];

		foreach($parameters as $parameter) {
			$dependency = $parameter->getClass();

			if ($dependency === NULL) {
				if ($parameter->isDefaultValueAvailable()) {
					$dependencies[] = $parameter->getDefaultValue();
				} else {
					$message = "Can not resolve class dependency {$parameter->name}";
				}
			} else {
				$dependencies[] = $this->set($dependency->name);
			}
		}

		return $dependencies;
	}
	
	public function has($abstract) {
		return array_key_exists($abstract, $this->instances);
	}
}