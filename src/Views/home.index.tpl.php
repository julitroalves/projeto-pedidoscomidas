<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $title; ?> </title>
</head>
<body>
	<?php if ($message): ?>
		<p><?= $message; ?></p>
	<?php endif; ?>
	
	<div class="container">
		<h1><?php echo $title; ?></h1>

		<p>Seja muito bem-vindo, <?php echo $name; ?>!<p>

		<ul>
			
			<?php foreach($products as $product): ?>
				<li>
					<?php 
						echo $product->id . ' - ' . $product->title . ' - ' . $product->description . ' - Preço: '. $product->price; 
					?>
						
				</li>
			<?php endforeach; ?>

		</ul>
	</div>
</body>
</html>