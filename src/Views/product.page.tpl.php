<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>		
		
		<?= $product->description; ?>

		<?= $product->price; ?>		
	</div>
</body>
</html>