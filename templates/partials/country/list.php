<article class="country is-list">
	<a href="<?= $this->url('country-permalink', ['slug' => $country->slug]) ?>">
		<img src="<?= $this->img($country->imageFile, 'resizeCrop,400,400') ?>" class="country-image">
		<h2 class="country-title"><?= $country->name ?></h2>
	</a>
</article>