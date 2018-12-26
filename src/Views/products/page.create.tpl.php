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
				<label>Capa do Produto</label>
				<br>
				<input type="file" name="cover">
			</div>

			<div>
				<label>Título: </label>
				<input type="text" name="title" placeholder="Digite o titulo do seu produto">
			</div>

			<div>
				<label>Descrição</label>
				<textarea name="description"></textarea>
			</div>

			<div>
				<label>Preço: </label>
				<input type="text" name="price" placeholder="Digite o preço do seu produto">
			</div>

			<div>
				<input type="submit" value="Cadastrar">
			</div>
		</form>
	</div>
</body>
</html>