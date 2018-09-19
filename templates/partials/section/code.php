<figure class="section section-code <?= preg_match('/(youtube|vimeo)/', $section['code']) ? 'is-responsive' : '' ?>">
	<?= $section['code'] ?>

	<?php if (!empty($section['caption'])): ?>
	<figcaption>
		<?= $section['caption'] ?>
	</figcaption>
	<?php endif ?>
</figure>