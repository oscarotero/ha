<?php
if ($artwork->imageWidth && $artwork->imageHeight) {
	$ratio = round(($artwork->imageWidth/$artwork->imageHeight) * 100, 2);
} else {
	$ratio = null;
}

if ($artwork->imageCropX === null || $artwork->imageCropY === null) {
	$crop = 'CROP_BALANCE';
} else {
	$crop = "{$artwork->imageCropX}%,{$artwork->imageCropY}%";
}

if ($prev && $prev->year === $artwork->year) {
	if ($next && $next->year === $artwork->year) {
		$modifier = 'is-middle';
	} else {
		$modifier = 'is-end';
	}
} elseif ($next && $next->year === $artwork->year) {
	$modifier = 'is-start';
} else {
	$modifier = '';
}
?>

<article class="artwork is-timeline"
		 style="--background-color: <?= $artwork->backgroundColor ?: 'white'; ?>;
		 		--foreground-color: <?= $artwork->foregroundColor ?: 'black'; ?>;">
	<a href="<?= $this->url('artwork-permalink', ['slug' => $artwork->slug]) ?>">
		<figure class="artwork-figure">
			<?php if ($ratio > 200): ?>
			<img src="<?= $this->img($artwork->imageFile, "resizeCrop,300,200,{$crop}") ?>" alt="Previsualización de la obra">
			<?php else: ?>
			<img src="<?= $this->img($artwork->imageFile, 'resize,300,300') ?>" alt="Previsualización de la obra">
			<?php endif ?>
		</figure>

		<time class="timeline-time artwork-time <?= $modifier ?>">
			<?= $artwork->year ?>
		</time>

		<header class="artwork-header">
			<h2 class="artwork-title">
				<?= $artwork->title ?>
			</h2>

			<p class="artwork-subtitle">
				<?= $artwork->subtitle ?>
			</p>
		</header>
	</a>
</article>