<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
	<h1><?= $title; ?></h1>

	<?php if ($message): ?>
		<p><?= $message; ?></p>
	<?php endif; ?>

	<div class="container">
		<form method="POST" accept-charset="utf-8">
			<input type="hidden" name="id" value="<?= $user->id; ?>">
			
			<div>
				<label>Username: </label>
				<input type="text" name="username" placeholder="Digite seu username" value="<?= $user->username; ?>">
			</div>

			<div>
				<label>Password Atual: </label>
				<input type="password" name="current_password" placeholder="Digite sua senha">
			</div>

			<div>
				<label>Novo Password: </label>
				<input type="password" name="password" placeholder="Digite sua senha">
			</div>

			<div>
				<label>Confirmação de Novo Password: </label>
				<input type="password" name="password2" placeholder="Confirme sua senha">
			</div>

			<div>
				<label>E-mail: </label>
				<input type="mail" name="email" placeholder="Digite seu e-mail" value="<?= $user->email; ?>">
			</div>

			<div>
				<label>Nome: </label>
				<input type="text" name="name" placeholder="Digite seu o seu nome" value="<?= $user->name; ?>">
			</div>

			<div>
				<input type="submit" value="Atualizar Conta">
			</div>
		</form>
	</div>
</body>
</html>