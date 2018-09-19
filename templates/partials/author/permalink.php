<?php
$layout = 'ly-author';

if (!$artworks->count()) {
	$layout .= ' has-no-artworks';
}

if  (!$artists->count()) {
	$layout .= ' has-no-artists';
}
?>

<article class="author is-permalink <?= $layout ?>">
	<div class="author-header ly-author-header">
		<?php if ($author->imageFile): ?>
			<img src="<?= $this->img($author->imageFile, 'resizeCrop,200,200') ?>" class="ly-author-header-image author-image">
		<?php else: ?>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="200" height="200" class="ly-author-header-image author-image">
				<line x1="0" y1="0" x2="100" y2="100"/>
				<line x1="0" y1="100" x2="100" y2="0"/>
			</svg>
		<?php endif ?>

		<header class="ly-author-header-header">
			<h1 class="author-name">
				<?= $author->name ?>
			</h1>

			<p class="author-title">
				<?php
				if ($author->title) {
					echo $author->title;

					if ((string) $author->country->name) {
						echo ", {$author->country->name}";
					}
				} elseif ((string) $author->country->name) {
					echo $author->country->name;
				}
				?>
			</p>
		</header>

		<div class="author-body ly-author-header-body">
			<?= $author->bio ?>

			<?php if ($author->links): ?>
			<nav class="author-links">
				<?php
				foreach ($author->links as $link) {
					switch ($link['type']) {
						case 'link':
							echo sprintf('<a href="%s" class="button">%s</a>', $link['url'], $link['text']);
							break;
						
						case 'email':
							echo sprintf('<a href="mailto:%s" class="button">%s</a>', $link['email'], $link['text']);
							break;
					}
				}
				?>
			</nav>
			<?php endif ?>
		</div>
	</div>


	<?php if ($artworks->count()): ?>
	<aside class="ly-author-artworks author-artworks group">
		<header class="group-header">
			<a href="<?= $this->url('artwork-search') ?>?author=<?= $author->slug ?>">
				<h2>
					Obras
					<em>analizadas</em>
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
	<aside class="ly-author-artists author-artists group">
		<header class="group-header">
			<a href="<?= $this->url('artist-search') ?>?author=<?= $author->slug ?>">
				<h2>
					Biografías
					<em>realizadas</em>
				</h2>

				<?php if ($artists->count() === 8): ?>
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
	<aside class="ly-author-reportages ly-author-reportages group">
		<header class="group-header">
			<h2>
				Artículos
				<em>realizados</em>
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
