<section class="section section-gallery carousel-wrapper">
	<ha-carousel role="region" aria-label="Galería" tabindex="0">
		<?php foreach ($section['images'] as $image): ?>
		<figure class="section section-image">
			<img src="<?= $this->img($image['image'], 'resize,880') ?>">

			<?php if (!empty($image['caption'])): ?>
			<figcaption>
				<?= $image['caption'] ?>
			</figcaption>
			<?php endif ?>
		</figure>
		<?php endforeach ?>
	</ha-carousel>
</section>