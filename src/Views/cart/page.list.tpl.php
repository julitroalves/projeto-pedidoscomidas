<div class="container">


	<form method="POST" accept-charset="utf-8" class="mt-2">
		<h1>Carrinho de Compras</h1>

		<input type="hidden" name="id" value="<?= $order->id; ?>">

		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Nome</th>
		      <th scope="col">Tipo</th>
		      <th scope="col">Preço</th>
		      <th scope="col">Quantidade</th>
		      <th scope="col">Ação</th>
		    </tr>
		  </thead>

		  <tbody>

		<?php foreach($order->items as $item): ?>
		    <tr>
		      <td>
		      	<?= $item->getProduct()->title; ?>
				
				<input type="hidden" name="line_items[<?= $item->id; ?>][id]" value="<?= $item->id; ?>">
				<input type="hidden" name="line_items[<?= $item->id; ?>][productID]" value="<?= $item->getProductID(); ?>">
		      </td>

		      <td>
		      	<?= $item->getTypeLabel(); ?>
		      </td>

		      <td>
					<input type="text" name="line_items[<?= $item->id; ?>][price]" placeholder="Digite o preço" value="<?= $item->getPrice(); ?>" disabled class="form-control">
		      </td>

		      <td>
					<input type="text" name="line_items[<?= $item->id; ?>][quantity]" placeholder="Digite a quantidade" value="<?= $item->getQuantity(); ?>" class="form-control">
		      </td>

		      <td>
				<a href="<?= "/cart/delete/{$item->getProductID()}"; ?>">Apagar</a>
		      </td>
		    </tr>
		<?php endforeach; ?>
		  </tbody>
		</table>

		<h4>Total: <?= $order->getTotal(); ?></h4>

		<div class="text-right">
			<a class="btn btn-primary" href="/checkout/payment">Ir para o pagamento</a>
		</div>
	</form>
</div>