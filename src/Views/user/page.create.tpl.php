<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title;?></h1>

	<?php if ($message): ?>
		<p><?= $message; ?></p>
	<?php endif; ?>

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
				<label>Confirmação de Password: </label>
				<input type="password" name="password2" placeholder="Confirme sua senha">
			</div>

			<div>
				<label>E-mail: </label>
				<input type="mail" name="email" placeholder="Digite seu e-mail">
			</div>

			<div>
				<label>Nome: </label>
				<input type="text" name="name" placeholder="Digite seu o seu nome">
			</div>

			<div>
				<input type="submit" value="Criar Conta">
			</div>
		</form>
	</div>
</body>
</html>