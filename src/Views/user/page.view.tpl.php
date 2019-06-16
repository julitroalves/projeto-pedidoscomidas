<div class="container">
	<h2><?php echo $title; ?></h2>

	<div>Nome: <?= $user->name; ?></div>

	<div>Username: <?= $user->username; ?></div>
	
	<div>E-mail: <?= $user->email; ?></div>
	
	<div>Criando em: <?= date('d/m/Y H:i:s', strtotime($user->created)); ?></div>

	<h4 class="mt-3">Pedidos</h4>
		<table class="table">
		  <thead>
		    <tr>
		      <th scope="col">ID</th>
		      <th scope="col">Total</th>
		      <th scope="col">Status</th>
		      <th scope="col">Criado em</th>
		      <th scope="col">Ação</th>
		    </tr>
		  </thead>
		  <tbody>
			<?php foreach($orders as $order): ?>
				<tr>
					<td><?= $order->id; ?></td>

					<td><?= $order->getTotal(); ?></td>
				
					<td><?= $order->getStatusLabel(); ?></td>
								
					<td><?= $order->created; ?></td>
				
					<td>
						<a href="/user/<?= $user->id; ?>/orders/<?= $order->id; ?>" class="link">
							Ver
						</a>
					</td>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
</div>