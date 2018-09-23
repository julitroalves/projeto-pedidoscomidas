<?php

namespace PedidosComidas\Template;

class SimpleTemplate implements Renderer {
	private $engine;

	public function __construct(SimpleTemplateEngine $engine) {
		$this->engine = $engine;
	}

	public function render($template, $context) {
		return $this->engine->render($template, $context);
	}
}