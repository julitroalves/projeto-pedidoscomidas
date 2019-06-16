<div class="container">
	<h1><?php echo $title; ?></h1>

	<ul>
		
		<?php foreach($orders as $order): ?>
			<li>
				<?php echo 'Author: '. $order->author; ?>
				<?php echo 'Status: '. $order->status; ?>
				<?php echo 'Total: '. $order->total; ?>
				<?php echo 'Criando em: '. $order->created; ?>
					
			</li>
		<?php endforeach; ?>

	</ul>
</div>