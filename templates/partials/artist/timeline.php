<?php
$artworks = array_values($artist->artwork()->orderBy('year')->orderBy('month')->run()->toArray(false));

if (!$artworks) {
	return;
}
?>

<ha-carousel class="timeline <?= $artist->yearDead ? 'has-dead' : '' ?>" role="region" aria-label="Obras de este artista" tabindex="0">
	<div class="is-born">
		<div class="timeline-content">
			<time class="timeline-time"><?= $artist->yearBorn ?: '?'; ?></time>
			<p>Nacimiento de<br> <?= $artist->name.' '.$artist->surname ?></p>
		</div>
	</div>

	<?php
	foreach ($artworks as $k => $artwork) {
		$prev = isset($artworks[$k - 1]) ? $artworks[$k - 1] : null;
		$next = isset($artworks[$k + 1]) ? $artworks[$k + 1] : null;

		$this->insert('partials/artwork/timeline', compact('artwork', 'next', 'prev'));
	}
	?>

	<?php if ($artist->yearDead): ?>
	<div class="is-dead">
		<time class="timeline-time"><?= $artist->yearDead ?></time>
		<p>Muerte</p>
	</div>
	<?php endif ?>
</ha-carousel>
