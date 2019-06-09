<?php

namespace PedidosComidas\Template;

use PedidosComidas\DI\Dependencies;
use PedidosComidas\Models\Cart\CartService;

class SimpleTemplate implements Renderer {
	private $engine;

	public function __construct(SimpleTemplateEngine $engine) {
		$this->engine = $engine;

		$this->cartService = new CartService();

		$this->injector = Dependencies::getContainer();
	}

	public function render(string $template, array $context = []) {
		$user = $this->injector->get('SessionStore')->get('user');

		$context['title'] = isset($context['title']) ? $context['title'] : '';

		if ($user) {
			$context['logged_user'] = $user;

			$context['cart_items_quantity'] = $this->cartService->getCartItemsQuantity($user['id']);
		}

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