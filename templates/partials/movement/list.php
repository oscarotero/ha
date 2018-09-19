<article class="movement is-list">
	<a href="<?= $this->url('movement-permalink', ['slug' => $movement->slug]) ?>">
		<img src="<?= $this->img($movement->imageFile, 'resizeCrop,400,400') ?>" class="movement-image">
		<header class="movement-header">
			<h2 class="movement-title"><?= $movement->name ?></h2>
			<p class="movement-years">
				<?php
				echo $movement->yearStart;

				if ($movement->yearEnd) {
					echo '–'.$movement->yearEnd;
				}
				?>
			</p>
		</header>
	</a>
</article>