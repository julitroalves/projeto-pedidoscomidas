<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<div class="container">
		<p>Author: <?= $order->author; ?></p>
		<p>Total: <?= $order->total; ?></p>

		<p>Status: <?= $order->status; ?></p>

		<form method="POST" accept-charset="utf-8">
			<input type="hidden" name="id" value="<?= $order->id; ?>">

			<h2>Itens do Pedidos</h2>

			<?php foreach($order->items as $item): ?>
				<div>
					<p>Product ID: <?= $item->getProductID(); ?></p>
					<p>Tipo: <?= $item->getType(); ?></p>
				</div>

				<input type="hidden" name="line_items[<?= $item->id; ?>][id]" value="<?= $item->id; ?>">
				<input type="hidden" name="line_items[<?= $item->id; ?>][productID]" value="<?= $item->getProductID(); ?>">

				<div>
					<label>Preço: </label>
					<input type="text" name="line_items[<?= $item->id; ?>][price]" placeholder="Digite o preço" value="<?= $item->getPrice(); ?>" disabled>
				</div>

				<div>
					<label>Quantidade: </label>
					<input type="text" name="line_items[<?= $item->id; ?>][quantity]" placeholder="Digite a quantidade" value="<?= $item->getQuantity(); ?>">
				</div>

				<a href="<?= "/cart/delete/{$item->getProductID()}"; ?>">Deletar Item</a>
			
			<hr>
			<?php endforeach; ?>


			<div>
				<input type="submit" value="Ir para o Pagamento">
			</div>
		</form>
	</div>
</body>
</html>