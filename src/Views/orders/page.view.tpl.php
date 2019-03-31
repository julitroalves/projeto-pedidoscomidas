<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>

		<p>Author: <?= $order->author; ?></p>
		<p>Total: <?= $order->total; ?></p>

		<p>Status: <?= $order->status; ?></p>
		<p>Criando em: <?= $order->created; ?></p>

		<h2>Itens do Pedidos</h2>
		<ul>
		<?php foreach($order->items as $item): ?>
			<li>
				N° Pedido: <?= $item->getOrderID(); ?> -
				Product ID: <?= $item->getProductID(); ?> - 
				Quantidade: <?= $item->getQuantity(); ?>
				Tipo: <?= $item->getType(); ?>
				Preço: <?= $item->getPrice(); ?>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</body>
</html>