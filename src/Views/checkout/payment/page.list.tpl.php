<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<?php if ($message): ?>
		<p><?= $message; ?></p>
	<?php endif; ?>

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
				<input type="radio" name="payment_method" value="<?= $payment->getID(); ?>" id="<?= $payment->getID(); ?>">

				<label for="<?= $payment->getID(); ?>"><?= $payment->getTitle(); ?></label>

				<p><?= $payment->getDescription(); ?></p>

				<div>
					<?= $payment->buildForm(); ?>					
				</div>
			<?php endforeach;?>

			<div>
				<input type="submit" name="todoPayment" value="Realizar Pagamento">
			</div>
		</form>
	</div>
</body>
</html>