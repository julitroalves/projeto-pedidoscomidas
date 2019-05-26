<?php

namespace PedidosComidas\Template;

class SimpleTemplate implements Renderer {
	private $engine;

	public function __construct(SimpleTemplateEngine $engine) {
		$this->engine = $engine;
	}

	public function render($template, $context) {

		$content = $this->engine->render($template, $context);
		
		$header = $this->engine->render('header', $context, FALSE);

		$footer = $this->engine->render('footer', $context, FALSE);

		$context2 = [
			'header' => $header,
			'content' => $content,
			'footer' => $footer
		];
		
		$htmlContext = array_merge($context, $context2);
		
		return $this->engine->render('html', $htmlContext);
	}
}