<div class="container">
	<h1><?php echo $title; ?></h1>
		
		<div class="row">
			<?php foreach($products as $product): ?>
				<div class="col">
					<div class="card" style="width: 18rem; margin: 5px">
						
						<?php if (isset($product->cover)): ?>
							<img src="<?= $product->cover->getUrl(); ?>" class="card-img-top">
						<?php else: ?>
							<img src="/images/default-product-image.png" class="card-img-top">
						<?php endif ; ?>

					  <div class="card-body">
					    <h5 class="card-title"><?= $product->title; ?></h5>

					    <p class="card-text"><?= $product->description; ?></p>

						<form method="POST" accept-charset="utf-8" action="/cart/add/<?= $product->id; ?>" >
							<input type="submit" class="btn btn-primary" name="add-to-cart" value="Comprar">
						</form>

					    <div class="price-container text-success"> 
					    	<span class="price-symbol">R$</span> 
					    	<span class="price-value"><?= $product->price; ?></span>
					    </div>
					  </div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
</div>