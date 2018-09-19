<article class="movement is-timeline">
	<a href="<?= $this->url('movement-permalink', ['slug' => $movement->slug]) ?>">
		<header class="movement-header">
			<h3 class="movement-name"><?= $movement->name ?></h3>
			<p class="movement-years">
				<?php
				echo $movement->yearStart;

				if ($movement->yearEnd) {
					echo '–'.$movement->yearEnd;
				}
				?>
			</p>
		</header>
		<img src="<?= $this->img($movement->imageFile, 'resizeCrop,100,100') ?>" class="movement-image">
	</a>
</article>