<figure class="section section-image">
	<div>
		<img src="<?= $this->img($section['image'], $bigImages ? 'resize,880,880' : 'resize,580') ?>">
	</div>

	<?php if (!empty($section['caption'])): ?>
	<figcaption>
		<?= $section['caption'] ?>
	</figcaption>
	<?php endif ?>
</figure>