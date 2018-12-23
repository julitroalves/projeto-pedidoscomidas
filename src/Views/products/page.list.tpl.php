<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<div class="container">
		<h1><?php echo $title; ?></h1>

		<ul>
			
			<?php foreach($products as $product): ?>
				<li>
					<?php 
						echo $product->title . ' - ' . $product->description . ' - Preço: '. $product->price; 
					?>
						
				</li>
			<?php endforeach; ?>

		</ul>
	</div>
</body>
</html>