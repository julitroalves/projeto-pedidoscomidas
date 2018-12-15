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
			
			<div>
				<label>Título: </label>
				<input type="text" name="title" value="<?= $product->title; ?>" placeholder="Digite o titulo do seu produto">
			</div>

			<div>
				<label>Descrição</label>
				<textarea name="description">
					<?= $product->description; ?>
				</textarea>
			</div>

			<div>
				<label>Preço: </label>
				<input type="text" name="price" value="<?= $product->price; ?>" placeholder="Digite o preço do seu produto">
			</div>

			<div>
				<input type="submit" value="Editar">
			</div>
		</form>
	</div>
</body>
</html>