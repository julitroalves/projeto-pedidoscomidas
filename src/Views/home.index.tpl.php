<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>

		<p>Seja muito bem-vindo, <?php echo $name; ?>!<p>

		<ul>
			
			<?php foreach($users as $user): ?>
				<li><?php echo $user->name . ' - ' . $user->email; ?></li>
			<?php endforeach; ?>

		</ul>
	</div>
</body>
</html>