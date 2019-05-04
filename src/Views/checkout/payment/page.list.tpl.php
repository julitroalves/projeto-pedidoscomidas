<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<div class="container">

		<form method="POST" accept-charset="utf-8">
			<input type="hidden" name="id" value="<?= $order->id; ?>">

			<h2>Resumo do Pedido</h2>

			<?php foreach($order->items as $item): ?>
				<div>
					<p>Product ID: <?= $item->getProductID(); ?></p>
					<p>Preço: <?= $item->getPrice(); ?></p>					
					<p>Quantidade: <?= $item->getQuantity(); ?></p>
				</div>
			<hr>
			<?php endforeach; ?>
			
			<h4>Total: <?= $order->total; ?></h4>

			<?php foreach($payments as $payment): ?>
				<h4><?= $payment; ?></h4>
				<p><?= $payment->getDescription(); ?></p>

				<div>
					<?= $payment->buildForm(); ?>					
				</div>
			<?php endforeach;?>

			<div>
				<a href="/checkout/completed">Realizar Pagamento</a>
			</div>
		</form>
	</div>
</body>
</html>