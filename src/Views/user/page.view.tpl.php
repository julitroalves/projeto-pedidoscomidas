<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>

		<div>Nome: <?= $user->name; ?></div>

		<div>Username: <?= $user->username; ?></div>
		
		<div>E-mail: <?= $user->email; ?></div>
		
		<div>Criando em: <?= date('d/m/Y H:i:s', strtotime($user->created)); ?></div>
	</div>
</body>
</html>