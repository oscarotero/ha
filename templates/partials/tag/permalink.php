<?php
$layout = 'ly-tag';

if (!$artworks->count()) {
	$layout .= ' has-no-artworks';
}

if  (!$artists->count()) {
	$layout .= ' has-no-artists';
}
?>

<article class="tag is-permalink <?= $layout ?>">
	<header class="tag-header ly-tag-header">
		<h1 class="tag-title">
			<?= $tag->name ?>
		</h1>
	</header>

	<?php if ($artworks->count()): ?>
	<aside class="ly-tag-artworks tag-artworks group">
		<header class="group-header">
			<a href="<?= $this->url('artwork-search') ?>?tag=<?= $tag->slug ?>">
				<h2>
					Obras etiquetadas
					<em>como &ldquo;<?= $tag->name ?>&rdquo;</em>
				</h2>

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
	<aside class="ly-tag-artists tag-artists group">
		<header class="group-header">
			<a href="<?= $this->url('artist-search') ?>?tag=<?= $tag->slug ?>">
				<h2>
					Artistas etiquetados
					<em>como &ldquo;<?= $tag->name ?>&rdquo;</em>
				</h2>

				<?php if ($artworks->count() === 8): ?>
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

	<?php if ($reportages->count()): ?>
	<aside class="ly-tag-reportages ly-tag-reportages group">
		<header class="group-header">
			<h2>
				Artículos etiquetados
				<em>como &ldquo;<?= $tag->name ?>&rdquo;</em>
			</h2>
		</header>

		<ul class="reportage-related-list">
			<?php foreach ($reportages as $reportage): ?>
			<li>
				<?php $this->insert('partials/reportage/list', compact('reportage')) ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
	<?php endif ?>
</article>
