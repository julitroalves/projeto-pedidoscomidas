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
			
			<div>
				<label>Status: </label>
				<input type="text" name="status" placeholder="Digite o status do pedido">
			</div>

			<div>
				<input type="submit" value="Editar">
			</div>
		</form>
	</div>
</body>
</html>