<div class="container">

	<form method="POST" accept-charset="utf-8" class="row my-5">
		<input type="hidden" name="id" value="<?= $order->id; ?>">

		
		<div class="col-md-4 order-2">

			<h4 class="d-flex justify-content-between align-items-center mb-3">
		    	<span class="text-muted">Carrinho</span>
		    	<span class="badge badge-secondary badge-pill"><?= $cart_items_quantity; ?></span>
		    </h4>
				
			<ul class="list-group mb-3">

				<?php foreach($order->items as $item): ?>
					<li class="list-group-item d-flex justify-content-between lh-condensed">
			          <div>
			            <h6 class="my-0"><?= $item->getProduct()->title; ?> X <?= $item->getQuantity(); ?></h6>
			            <small class="text-muted"><?= $item->getProduct()->description; ?></small>
			          </div>
			          <span class="text-muted">R$ <?= $item->getPrice(); ?></span>
			        </li>
				<?php endforeach; ?>
			
				<li class="list-group-item d-flex justify-content-between">
		          <span>Total</span>
		          <strong>R$ <?= $order->getTotal(); ?></strong>
		        </li>
			</ul>
		</div>

		<div class="col-md-8 order-1">
			<h4 class="mb-3">Métodos de Pagamento</h4>

			<?php foreach($payments as $payment): ?>
				<div class="custom-control custom-radio mb-3">
					<input type="radio" name="payment_method" value="<?= $payment->getID(); ?>" id="<?= $payment->getID(); ?>" class="custom-control-input">

					<label for="<?= $payment->getID(); ?>" class="custom-control-label"><?= $payment->getTitle(); ?></label>

					<span class="text-muted"><?= $payment->getDescription(); ?></span>

					<div class="row">
						<?= $payment->buildForm(); ?>					
					</div>
				</div>
			<?php endforeach;?>

			<hr class="mb-4">

			<input type="submit" name="todoPayment" value="Finalizar Pagamento" class="btn btn-primary btn-lg btn-block">
		</div>
	</form>
</div>