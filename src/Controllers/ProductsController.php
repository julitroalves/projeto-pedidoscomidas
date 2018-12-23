<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

use PedidosComidas\Models\Product\ProductService;

class ProductsController {

	public function index($request, $response, $renderer) {
		$productService = new ProductService();
		
		$products = $productService->load();

		$context = [
			'title' => "Listagem de Produtos",
			'products' => $products,
		];

		$content = $renderer->render("products.page", $context);

		$response->setContent($content);

		return $response->send();
	}
	
	public function getOne($request, $response, $renderer, $params = []) {
		$productService = new ProductService();

		$product = $productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => $product->title,
			'product' => $product,
		];

		$content = $renderer->render("product.page", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreate($request, $response, $renderer) {
		$context = [
			'title' => 'Criar Produto'
		];

		$content = $renderer->render('product.create.page', $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreateSubmit($request, $response, $renderer) {
		$formData = $request->request->all();

		$productService = new ProductService();

		$productService->create([
			'title' => $formData['title'],
			'description' => $formData['description'],
			'price' => $formData['price'],
			'author' => '1',
			'created'  => date('Y-m-d H:i:s', time()),
			'updated'  => NULL
		]);

		$response = new RedirectResponse('/');
		
		return $response->send();
	}

	public function formEdit($request, $response, $renderer, $params = []) {
		$productService = new ProductService();

		$product = $productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Edição de Produto',
			'product' => $product
		];

		$response->setContent($renderer->render("product.edit.page", $context));

		return $response->send();
	}

	public function formEditSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();

		$productService = new ProductService();

		$product = $productService->findByID($formData['id']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$productUpdated = $productService->edit($product, [
			'id' => $formData['id'],
			'title' => $formData['title'],
			'description' => $formData['description'],
			'price' => $formData['price'],
		]);


		if (!$productUpdated) {
			$context = ['Infelizmente não foi possível atualizar este produto.'];

			$response->setContent($renderer->render("page.error", $context));

			return $response->send();
		}

		$response = new RedirectResponse('/');
		
		return $response->send();
	}

	public function formDelete($request, $response, $renderer, $params = []) {
		$productService = new ProductService();

		$product = $productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Deletar Produto',
			'product' => $product,
		];

		$response->setContent($renderer->render("product.delete.page", $context));

		return $response->send();
	}

	public function formDeleteSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();

		$productService = new ProductService();

		$product = $productService->findByID($formData['id']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$productService->delete($product);

		$response = new RedirectResponse('/');

		return $response->send();
	}

	
}