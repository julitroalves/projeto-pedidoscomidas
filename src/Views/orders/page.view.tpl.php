<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>

		Author: <?= $order->author; ?>
		Total: <?= $order->total; ?>

		Status: <?= $order->status; ?>		
		Criando em: <?= $order->created; ?>		
	</div>
</body>
</html>