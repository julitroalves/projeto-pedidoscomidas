<?php

namespace PedidosComidas\Template;

class SimpleTemplateEngine {
	private $baseDir;

	function __construct() {
		$this->baseDir = dirname(__DIR__);
	}

	public function render($template, $context = []) {
		$templatePath = $this->baseDir . '/Views/' . $template . '.tpl.php';

		if (!is_readable($templatePath)) {
			$message = "The template {$templatePath} file not found or is not possible to read.";
			
			throw new \Exception($message);
		}

		extract($context);

		ob_start();

		include($templatePath);

		return ob_get_clean();
	}
}