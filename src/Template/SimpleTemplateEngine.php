<?php

namespace PedidosComidas\Template;

class SimpleTemplateEngine {
	private $baseDir;

	function __construct() {
		$this->baseDir = dirname(__DIR__);
	}

	public function render(string $template, array $context = [], bool $isRequired = true) {
		$templatePath = $this->baseDir . '/Views/' . $template . '.tpl.php';

		if (!is_readable($templatePath)) {
			if (!$isRequired) {
				return;
			}

			$message = "The template {$templatePath} file not found or is not possible to read.";
			
			throw new \Exception($message);
		}

		extract($context);

		ob_start();

		include($templatePath);

		return ob_get_clean();
	}
}