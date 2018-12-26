<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>		
		
		<?php if ($product->cover): ?>
			<div>
				Foto:
				<img src="<?= $product->cover->getUrl(); ?>" width="500">
			</div>
		<?php endif; ?>

		<?= $product->description; ?>

		<?= $product->price; ?>		
	</div>
</body>
</html>