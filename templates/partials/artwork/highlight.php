<article class="artwork is-highlight" 
		 style="--background-color: <?= $artwork->backgroundColor ?: 'white'; ?>;
		 		--foreground-color: <?= $artwork->foregroundColor ?: 'black'; ?>;">
	<a href="<?= $this->url('artwork-permalink', ['slug' => $artwork->slug]) ?>">
		<h2 class="artwork-subtitle">
			<?= $artwork->subtitle ?>
		</h2>
		<div class="artwork-details">
			<?php foreach ($artwork->artist as $artist): ?>
				<img src="<?= $this->img($artist->imageFile, 'resizeCrop,50,50') ?>" alt="Previsualización de la obra">
				<p><strong><?= $artwork->title ?></strong></p>
				<p><?= $artist->name.' '.$artist->surname ?>, <?= $artwork->year ?></p>
			<?php endforeach ?>
		</div>
	</a>
</article>