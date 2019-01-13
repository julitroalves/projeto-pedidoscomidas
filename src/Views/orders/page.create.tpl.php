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
				<input type="submit" value="Cadastrar">
			</div>
		</form>
	</div>
</body>
</html>