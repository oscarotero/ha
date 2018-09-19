<a href="<?= $this->url('artist-permalink', ['slug' => $artist->slug]) ?>" class="artist is-link">
	<?php if (empty($no_image)): ?>
	<img src="<?= $this->img($artist->imageFile, 'resizeCrop,50,50') ?>" alt="Retrato del artista">
	<?php endif ?>
	<strong><?= $artist->name.' '.$artist->surname ?></strong>
</a>