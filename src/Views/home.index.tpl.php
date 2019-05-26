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