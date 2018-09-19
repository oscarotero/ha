<article class="technique is-list">
	<a href="<?= $this->url('technique-permalink', ['slug' => $technique->slug]) ?>">
		<img src="<?= $this->img($technique->imageFile, 'resizeCrop,400,400') ?>" class="technique-image">
		<h2 class="technique-title"><?= $technique->name ?></h2>
	</a>
</article>