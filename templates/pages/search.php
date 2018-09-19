<?php 
$term = $this->e($term);

$page = new SocialLinks\Page([
	'url' => $this->url('search').'?q='.$term,
	'title' => 'Resultados de búsqueda por "'.$term.'"',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-result'
]);

$this->insert('partials/navbar', [
	'title' => "Búsqueda por <em>&ldquo;{$term}&rdquo;</em>"
]);
?>

<main class="ly-result">
	<div class="ly-result-content">
		<?php
		if (!empty($isEmpty)):
			$this->insert('partials/search-empty', compact('term'));
		else:
			$isEmpty = true;
		?>

		<?php if ($artists->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Artistas</h2>
			</header>

			<ul class="artist-related-list">
				<?php foreach ($artists as $artist): ?>
				<li>
					<?php $this->insert('partials/artist/list', compact('artist')); ?>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>


		<?php if ($movements->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Movimientos</h2>
			</header>

			<ul class="movement-related-list">
				<?php foreach ($movements as $movement): ?>
				<li>
					<?php $this->insert('partials/movement/list', compact('movement')); ?>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php if ($techniques->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Técnicas</h2>
			</header>

			<ul class="technique-related-list">
				<?php foreach ($techniques as $technique): ?>
				<li>
					<?php $this->insert('partials/technique/list', compact('technique')); ?>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php if ($countries->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Países</h2>
			</header>

			<ul class="country-related-list">
				<?php foreach ($countries as $country): ?>
				<li>
					<?php $this->insert('partials/country/list', compact('country')); ?>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php if ($artworks->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Obras</h2>
			</header>

			<ul class="artwork-related-list">
				<?php foreach ($artworks as $artwork): ?>
				<li>
					<?php $this->insert('partials/artwork/list', compact('artwork')); ?>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php if ($reportages->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Artículos</h2>
			</header>

			<ul class="reportage-related-list">
				<?php foreach ($reportages as $reportage): ?>
				<li>
					<?php $this->insert('partials/reportage/list', compact('reportage')); ?>
				</li>
				<?php endforeach ?>
			</ul>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php if ($museums->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Museos</h2>
			</header>

			<?php $this->insert('partials/museum/search-list', compact('museums') + ['full' => true]); ?>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php if ($tags->count()): ?>
		<section class="ly-result-block group">
			<header class="group-header">
				<h2>Etiquetas</h2>
			</header>

			<?php $this->insert('partials/tag/search-list', compact('tags')); ?>
			<?php $isEmpty = false; ?>
		</section>
		<?php endif ?>

		<?php
		if ($isEmpty === true) {
			$this->insert('partials/search-empty', compact('term'));
		}
		?>
		<?php endif ?>
	</div>
</main>