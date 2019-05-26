<div class="container">
	<h1><?php echo $title; ?></h1>

	<ul>
		
		<?php foreach($products as $product): ?>
			<li>
				<?php 
					echo $product->title . ' - ' . $product->description . ' - Preço: '. $product->price; 
				?>
				
				<form method="POST" accept-charset="utf-8" action="/cart/add/<?= $product->id; ?>" >
					<input type="submit" name="Adicionar ao Carrinho">
				</form>
			</li>
		<?php endforeach; ?>

	</ul>
</div>