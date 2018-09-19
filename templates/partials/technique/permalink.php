<article class="technique is-permalink ly-technique">
	<figure class="technique-image ly-technique-image">
		<?php
		echo ViewHelpers\Html::picture(
			[
				$this->img($technique->imageFile, 'resizeCrop,400,150,CROP_ENTROPY'),
				'(min-width:960px) AND (min-height:1000px)' => $this->img($technique->imageFile, 'resizeCrop,500,1200,CROP_ENTROPY'),
				'(min-width:960px)' => $this->img($technique->imageFile, 'resizeCrop,500,800,CROP_ENTROPY'),
				'(min-width:600px)' => $this->img($technique->imageFile, 'resizeCrop,600,200,CROP_ENTROPY'),
			],
			$technique->name
		);
		?>
	</figure>

	<header class="technique-header ly-technique-header">
		<h1 class="technique-title">
			<?= $technique->name ?>
		</h1>
	</header>

	<div class="technique-description ly-technique-description">
		<?= $technique->description ?>
	</div>

	<aside class="ly-technique-artworks technique-artworks group">
		<header class="group-header">
			<a href="<?= $this->url('artwork-search') ?>?technique=<?= $technique->slug ?>">
				<h2>
					Obras creadas
					<em>con <?= $technique->name ?></em>
				</h2>

				<?php if ($artworks->count() === 6): ?>
				<span class="button-icon">
					<?php $this->insert('partials/icons/plus') ?>
				</span>
				<?php endif ?>
			</a>
		</header>

		<ul class="artwork-related-list">
			<?php foreach ($artworks as $artwork): ?>
			<li>
				<?php $this->insert('partials/artwork/list', compact('artwork')); ?>
			</li>
			<?php endforeach ?>
		</ul>
	</aside>
</article>
