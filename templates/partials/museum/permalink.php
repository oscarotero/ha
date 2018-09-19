<?php
$layout = 'ly-museum';

if (!$museums->count()) {
	$layout .= ' has-no-museums';
}
?>

<article class="museum is-permalink <?= $layout ?>">
	<header class="ly-museum-header museum-header">
		<h1 class="museum-title"><?= $museum->name ?></h1>
		<p class="museum-location">
			<?= $museum->city->name ?>,
			<a href="<?= $this->url('country-permalink', ['slug' => $museum->city->country->slug]) ?>">
				<?= $museum->city->country->name ?>
			</a>
		</p>
	</header>

	<?php if ($artworks->count()): ?>
	<section class="museum-artworks ly-museum-artworks">
		<ul class="artwork-related-list">
			<?php foreach ($artworks as $artwork): ?>
			<li>
				<?php $this->insert('partials/artwork/list', ['artwork' => $artwork]); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</section>
	<?php endif ?>

	<figure class="museum-map ly-museum-map js-gmap-point" data-coords="<?= json_encode($museum->location) ?>">
		<div class="js-gmap"></div>
	</figure>

	<?php if ($museums->count()): ?>
	<section class="museum-related ly-museum-museums">
		<header class="subheader">
			<h2>Otros museos <em>en <?= $museum->city->name ?></em></h2>
		</header>

		<?php $this->insert('partials/museum/search-list', compact('museums')) ?>
	</section>
	<?php endif ?>
</article>