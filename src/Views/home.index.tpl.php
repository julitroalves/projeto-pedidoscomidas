<div class="container">
	<h1><?php echo $title; ?></h1>

	<p>Seja muito bem-vindo, <?php echo $name; ?>!<p>
		
		<div class="row">
			<?php foreach($products as $product): ?>
				<div class="col">
					<div class="card" style="width: 18rem; margin: 5px">
						
						<a href="<?= $product->getUrl(); ?>">
							<?php if (isset($product->cover)): ?>
								<img width="300" height="300" src="<?= $product->cover->getUrl(); ?>" class="card-img-top">
							<?php else: ?>
								<img width="300" height="300" src="/images/default-product-image.png" class="card-img-top">
							<?php endif ; ?>
						</a>

					  <div class="card-body">
					  	<a href="<?= $product->getUrl(); ?>">
					    	<h5 class="card-title"><?= $product->title; ?></h5>
						</a>

					    <p class="card-text"><?= $product->description; ?></p>

						<form method="POST" accept-charset="utf-8" action="/cart/add/<?= $product->id; ?>" class="form-add-to-cart">
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