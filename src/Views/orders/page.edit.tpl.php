<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<?php if ($message): ?>
		<?= $message; ?>
	<?php endif; ?>

	<div class="container">

		<p>Author: <?= $order->author; ?></p>
		<p>Total: <?= $order->total; ?></p>

		<p>Status: <?= $order->status; ?></p>
		<p>Criando em: <?= $order->created; ?></p>


		<form method="POST" accept-charset="utf-8">
			<input type="hidden" name="id" value="<?= $order->id; ?>">
			
			<div>
				<label>Status: </label>
				<input type="text" name="status" placeholder="Digite o status do pedido" value="<?= $order->status; ?>">
			</div>

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
					<input type="text" name="line_items[<?= $item->id; ?>][price]" placeholder="Digite o preço" value="<?= $item->getPrice(); ?>">
				</div>

				<div>
					<label>Quantidade: </label>
					<input type="text" name="line_items[<?= $item->id; ?>][quantity]" placeholder="Digite a quantidade" value="<?= $item->getQuantity(); ?>">
				</div>

				<a href="<?= "/user/{$userID}/orders/{$order->id}/items/{$item->id}/delete"; ?>">Deletar Item</a>
			
			<hr>
			<?php endforeach; ?>


			<div>
				<label>Product ID: </label>
				<input type="text" name="line_items[0][productID]" placeholder="Digite o id do PRODUTO">
			</div>

			<div>
				<label>Preço: </label>
				<input type="text" name="line_items[0][price]" placeholder="Digite o preço">
			</div>

			<div>
				<label>Quantidade: </label>
				<input type="text" name="line_items[0][quantity]" placeholder="Digite a quantidade">
			</div>

			<div>
				<input type="submit" value="Editar">
			</div>
		</form>
	</div>
</body>
</html>