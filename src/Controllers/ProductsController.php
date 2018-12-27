<?php

namespace PedidosComidas\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

use PedidosComidas\Models\Product\ProductService;
use PedidosComidas\Models\File\FileService;

class ProductsController extends AbstractController {

	private $productService;

	public function __construct() {
		parent::__construct();
		
		$this->productService = new ProductService();
	}

	public function index($request, $response, $renderer) {
		
		$products = $this->productService->load();

		$context = [
			'title' => "Listagem de Produtos",
			'products' => $products,
		];

		$content = $renderer->render("products/page.list", $context);

		$response->setContent($content);

		return $response->send();
	}
	
	public function getOne($request, $response, $renderer, $params = []) {

		$product = $this->productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$fileService = new FileService([]);
		$product->cover = $fileService->findByID($product->coverID);

		$context = [
			'title' => $product->title,
			'product' => $product,
		];

		$content = $renderer->render("products/page.view", $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreate($request, $response, $renderer) {
		$context = [
			'title' => 'Criar Produto'
		];

		$content = $renderer->render('products/page.create', $context);

		$response->setContent($content);

		return $response->send();
	}

	public function formCreateSubmit($request, $response, $renderer) {
		$formData = $request->request->all();

		$this->productService->create($formData);

		$response = new RedirectResponse('/');
		
		return $response->send();
	}

	public function formEdit($request, $response, $renderer, $params = []) {

		$product = $this->productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Edição de Produto',
			'product' => $product
		];

		$response->setContent($renderer->render("products/page.edit", $context));

		return $response->send();
	}

	public function formEditSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();


		$product = $this->productService->findByID($formData['id']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$productUpdated = $this->productService->edit($product, [
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

		$product = $this->productService->findByID($params['{int}']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$context = [
			'title' => 'Deletar Produto',
			'product' => $product,
		];

		$response->setContent($renderer->render("products/page.delete", $context));

		return $response->send();
	}

	public function formDeleteSubmit($request, $response, $renderer, $params = []) {
		$formData = $request->request->all();


		$product = $this->productService->findByID($formData['id']);

		if (!$product) {
			$response->setContent($renderer->render("page.not-found"));

			return $response->send();
		}

		$this->productService->delete($product);

		$response = new RedirectResponse('/');

		return $response->send();
	}
}