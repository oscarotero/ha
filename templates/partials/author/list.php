<article class="author is-list">
	<a href="<?= $this->url('author-permalink', ['slug' => $author->slug]) ?>">
		<?php if ($author->imageFile): ?>
			<img src="<?= $this->img($author->imageFile, 'resizeCrop,200,200') ?>" class="author-image">
		<?php else: ?>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="author-image">
				<line x1="0" y1="0" x2="100" y2="100"/>
				<line x1="0" y1="100" x2="100" y2="0"/>
			</svg>
		<?php endif ?>

		<header class="author-header">
			<h2 class="author-name"><?= $author->name ?></h2>
			<p class="author-title"><?= $author->title ?></p>
		</header>
	</a>
</article>