<div class="container">

	<div class="row mt-5">
		<div class="col-4">
			<?php if (isset($product->cover)): ?>
				<img width="500" height="300" src="<?= $product->cover->getUrl(); ?>" class="card-img-top">
			<?php else: ?>
				<img width="500" height="300" src="/images/default-product-image.png" class="card-img-top">
			<?php endif; ?>
		</div>

		<div class="col-8">
			<h1><?= $product->title; ?></h1>

			<div class="product-container-description">
				<?= $product->description; ?>
			</div>

			<form method="POST" accept-charset="utf-8" action="/cart/add/<?= $product->id; ?>" class="form-add-to-cart">
				<input type="submit" class="btn btn-primary" name="add-to-cart" value="Comprar">
			</form>

		    <div class="price-container"> 
		    	<span class="price-text">Apenas</span>
		    	<span class="price-symbol text-success">R$</span> 
		    	<span class="price-value text-success"><?= $product->price; ?></span>
		    </div>
		</div>
	</div>



</div>