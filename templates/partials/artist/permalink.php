<?php
$content = $this->fetch('partials/section/sections', ['sections' => $artist->body]);
$timeline = $this->fetch('partials/artist/timeline', compact('artist'));

$layout = 'ly-artist';

if (empty($content)) {
	$layout .= ' has-no-content';
}

if (empty($timeline)) {
	$layout .= ' has-no-timeline';
}
?>
<article class="artist is-permalink <?= $layout ?>">
	<figure class="artist-image ly-artist-image">
		<img src="<?= $this->img($artist->imageFile, 'resizeCrop,400,400,CROP_ENTROPY') ?>" width="400" height="400" alt="Retrato del artista">
	</figure>

	<header class="artist-header ly-artist-header">
		<h1 class="artist-title">
			<?= $artist->name.' '.$artist->surname ?>
		</h1>

		<p class="artist-info">
			<?php
			if ($artist->country) {
				echo "<a href=\"{$this->url('country-permalink', ['slug' => $artist->country->slug])}\">{$artist->country->name}</a>, ";
			}

			echo $artist->yearBorn ?: '?';

			if ($artist->yearDead) {
				echo '–'.$artist->yearDead;
			}
			?>
		</p>
	</header>

	<div class="ly-artist-nav artist-details">
		<footer class="artist-footer taxonomy">
			<?php
			$this->insert('partials/taxonomy-tags', [
				'movement' => $artist->movement,
				'tag' => $artist->tag
			]);
			?>
		</footer>
	</div>
	
	<?php if (!empty($content)): ?>
	<div class="artist-bio ly-artist-content">
		<?= $content ?>
	</div>
	<?php endif ?>

	<?php if (!empty($timeline)): ?>
	<aside class="ly-artist-timeline artist-timeline timeline-wrapper">
		<?= $timeline ?>
	</aside>
	<?php endif ?>

	<aside class="ly-artist-related artist-related">
		<header class="subheader">
			<h2>
				Otros artistas
				<em>relacionados</em>
			</h2>
		</header>

		<ul class="artist-related-list">
			<?php foreach ($related as $rel): ?>
			<li>
				<?php $this->insert('partials/artist/list', ['artist' => $rel]) ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
</article>
