<?php
$layout = 'ly-special';

if (!$reportages->count()) {
	$layout .= ' has-no-reportages';
}

if (!$artworks->count()) {
	$layout .= ' has-no-artworks';
}

if (empty($special->description)) {
	$layout .= ' has-no-description';
}
?>
<article class="special is-permalink <?= $layout ?>">
	<header class="special-header ly-special-header">
		<h1 class="special-title">
			<?= $special->name ?>
		</h1>
		<p class="special-dates">
			<?= $special->startsAt->format('d/m/Y') ?>–<?= $special->endsAt->format('d/m/Y') ?>
		</p>
	</header>

	<div class="special-description ly-special-description">
		<?= $special->description ?>
	</div>

	<?php if ($artworks->count()): ?>	
	<aside class="ly-special-artworks special-artworks">
		<ul class="artwork-related-list">
			<?php foreach ($artworks as $artwork): ?>
			<li>
				<?php $this->insert('partials/artwork/list', compact('artwork')); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
	<?php endif ?>

	<?php if ($reportages->count()): ?>
	<aside class="ly-special-reportages ly-special-reportages">
		<ul class="reportage-related-list">
			<?php foreach ($reportages as $reportage): ?>
			<li>
				<?php $this->insert('partials/reportage/list', compact('reportage')) ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
	<?php endif ?>

	<aside class="special-specials ly-special-related">
		<header class="subheader">
			<h2>Otras semanas especiales</h2>
		</header>

		<?php $this->insert('partials/special/search-list', compact('specials')) ?>
	</aside>
</article>
