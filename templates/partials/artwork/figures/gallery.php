<ha-carousel class="artwork-gallery" role="region" aria-label="Galería" tabindex="0">
	<?php
	$this->insert('partials/artwork/figures/image', [
		'image' => $firstImage,
		'sizes' => $sizes,
		'caption' => $firstImageCaption,
	]);

	foreach ($images as $image) {
		$this->insert('partials/artwork/figures/image', [
			'image' => $image['image'],
			'sizes' => $sizes,
			'caption' => $image['caption'] ?? null,
		]);
	}
	?>
</ha-carousel>
