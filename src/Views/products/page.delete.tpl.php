<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<div class="container">
		<form method="POST" accept-charset="utf-8">
			<input type="hidden" name="id" value="<?= $product->id; ?>">
			
			<p>Você tem certeza que desejar deletar o seguinte produto: <b><?= $product->title; ?></b></p>


			<div>
				<a href="/">Cancelar</a>

				<input type="submit" value="Deletar">
			</div>
		</form>
	</div>
</body>
</html>