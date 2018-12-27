<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title;?></h1>

	<div class="container">
		<form method="POST" accept-charset="utf-8">			
			<div>
				<label>Username: </label>
				<input type="text" name="username" placeholder="Digite seu username">
			</div>

			<div>
				<label>Password: </label>
				<input type="password" name="password" placeholder="Digite sua senha">
			</div>

			<div>
				<input type="submit" value="Entrar">
			</div>
		</form>
	</div>
</body>
</html>