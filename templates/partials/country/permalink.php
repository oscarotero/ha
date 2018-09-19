<?php
$cities = $country->city()->orderBy('name')->run();

$layout = 'ly-country';

if (!$artworks->count()) {
	$layout .= ' has-no-artworks';
}

if (!$cities->count()) {
	$layout .= ' has-no-museums';
}

if (!$artists->count()) {
	$layout .= ' has-no-artists';
}
?>

<article class="country is-permalink <?= $layout ?>">
	<header class="ly-country-header">
		<h1 class="country-title"><?= $country->name ?></h1>
	</header>

	<?php if ($artworks->count()): ?>
	<section class="country-artworks ly-country-artworks group">
		<header class="group-header">
			<a href="<?= $this->url('artwork-search') ?>?country=<?= $country->slug ?>">
				<h2>Obras <em><?= $country->gentileFemale ?></em></h2>

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
				<?php $this->insert('partials/artwork/list', ['artwork' => $artwork]); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</section>
	<?php endif ?>

	<?php if ($artists->count()): ?>
	<section class="country-artists ly-country-artists group">
		<header class="group-header">
			<a href="<?= $this->url('artist-search') ?>?country=<?= $country->slug ?>">
				<h2>Artistas <em><?= $country->gentileMale ?></em></h2>

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
				<?php $this->insert('partials/artist/list', ['artist' => $artist]); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</section>
	<?php endif ?>

	<?php if ($cities->count()): ?>
	<section class="country-museums ly-country-museums group">
		<header class="group-header">
			<h2>Museos <em><?= $country->gentileMale ?></em></h2>
		</header>

		<?php $this->insert('partials/museum/list-cities', compact('cities')) ?>
	</section>

	<figure class="country-map ly-country-map">
		<div class="js-gmap"></div>
	</figure>
	<?php endif ?>
</article>