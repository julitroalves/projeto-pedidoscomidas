<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<div class="container">
		<form method="POST" accept-charset="utf-8" enctype="multipart/form-data">

			<div>
				<label>Status: </label>
				<input type="text" name="status" placeholder="Digite o status do pedido">
			</div>

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
				<input type="submit" value="Cadastrar">
			</div>
		</form>
	</div>
</body>
</html>