<?php

namespace PedidosComidas\Template;

interface Renderer {
	public function render(string $template, array $context);
}