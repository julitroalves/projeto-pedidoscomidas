<?php

namespace PedidosComidas\Template;

interface Renderer {
	public function render($template, $context);
}