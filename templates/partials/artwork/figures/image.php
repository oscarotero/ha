<figure class="artwork-figure">
	<?php
	echo ViewHelpers\Html::picture(
		[
			$this->img($image, $sizes[0]),
			'(min-width:2000px)' => $this->img($image, $sizes[4]),
			'(min-width:1500px)' => $this->img($image, $sizes[3]),
			'(min-width:1000px)' => $this->img($image, $sizes[2]),
			'(min-width:500px)' => $this->img($image, $sizes[1]),
		],
		[
			'alt' => $alt ?? '',
			'class' => 'js-viewer',
			'data-viewer-src' => $this->img($image, ''),
		]
	);
	?>

	<?php if (!empty($caption)): ?>
	<figcaption>
		<?= $caption ?>
	</figcaption>
	<?php endif ?>
</figure>