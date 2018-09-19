<?php
$layout = 'ly-movement';

if (!$artworks->count()) {
	$layout .= ' has-no-artworks';
}

if  (!$artists->count()) {
	$layout .= ' has-no-artists';
}
?>

<article class="movement is-permalink <?= $layout ?>">
	<figure class="movement-image ly-movement-image">
		<?php
		echo ViewHelpers\Html::picture(
			[
				$this->img($movement->imageFile, 'resizeCrop,400,150,CROP_ENTROPY'),
				'(min-width:960px) AND (min-height:1000px)' => $this->img($movement->imageFile, 'resizeCrop,500,1200,CROP_ENTROPY'),
				'(min-width:960px)' => $this->img($movement->imageFile, 'resizeCrop,500,800,CROP_ENTROPY'),
				'(min-width:600px)' => $this->img($movement->imageFile, 'resizeCrop,600,200,CROP_ENTROPY'),
			],
			$movement->name
		);
		?>
	</figure>

	<header class="ly-movement-header movement-header">
		<h1 class="movement-title"><?= $movement->name ?></h1>
		<p class="movement-years">
			<?php
			echo $movement->yearStart;

			if ($movement->yearEnd) {
				echo '–'.$movement->yearEnd;
			}
			?>
		</p>
	</header>

	<div class="movement-description ly-movement-description">
		<?= $movement->description ?>
	</div>

	<?php if ($artworks->count()): ?>
	<aside class="movement-artworks ly-movement-artworks group">
		<header class="group-header">
			<a href="<?= $this->url('artwork-search') ?>?movement=<?= $movement->slug ?>">
				<h2>Obras <em>representativas</em></h2>

				<?php if ($artworks->count() === 6): ?>
				<span class="button-icon">
					<?php $this->insert('partials/icons/plus') ?>
				</span>
				<?php endif ?>
			</a>
		</header>

		<ul class="artwork-related-list">
			<?php foreach ($artworks as $artwork): ?>
			<li>
				<?php $this->insert('partials/artwork/list', compact('artwork')); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
	<?php endif ?>

	<?php if ($artists->count()): ?>
	<aside class="movement-artists ly-movement-artists group">
		<header class="group-header">
			<a href="<?= $this->url('artist-search') ?>?movement=<?= $movement->slug ?>">
				<h2>Artistas <em>representativos</em></h2>

				<?php if ($artists->count() === 6): ?>
				<span class="button-icon">
					<?php $this->insert('partials/icons/plus') ?>
				</span>
				<?php endif ?>
			</a>
		</header>

		<ul class="artist-related-list">
			<?php foreach ($artists as $artist): ?>
			<li>
				<?php $this->insert('partials/artist/list', compact('artist')); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
	<?php endif ?>

	<aside class="movement-related ly-movement-movements">
		<header class="subheader">
			<h2>Otros movimientos <em>de <?= $movement->movementGroup->name ?></em></h2>
		</header>

		<?php $this->insert('partials/movement/search-list', compact('movements')) ?>
	</aside>
</article>
