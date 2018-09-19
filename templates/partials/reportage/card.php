<article class="reportage is-card"
		 style="--background-color: <?= $reportage->backgroundColor ?: 'white'; ?>;
		 		--foreground-color: <?= $reportage->foregroundColor ?: 'black'; ?>;">
	<a href="<?= $this->url('reportage-permalink', ['slug' => $reportage->slug]) ?>">
		<figure class="reportage-image">
			<img src="<?= $this->img($reportage->imageFile, 'resizeCrop,300,200') ?>">
		</figure>
		<header class="reportage-header">
			<h2 class="reportage-title"><?= $reportage->title ?></h2>
			<p class="reportage-subtitle"><?= $reportage->subtitle ?></p>
			<p class="reportage-author">Por <?= $reportage->author->name ?></p>
		</header>
	</a>
</article>