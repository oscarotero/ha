<?php
if ($artwork->imageCropX === null || $artwork->imageCropY === null) {
	$crop = 'CROP_BALANCE';
} else {
	$crop = "{$artwork->imageCropX}%,{$artwork->imageCropY}%";
}
?>

<article class="artwork is-list" 
		 style="--background-color: <?= $artwork->backgroundColor ?: 'white'; ?>;
		 		--foreground-color: <?= $artwork->foregroundColor ?: 'black'; ?>;">
	<a href="<?= $this->url('artwork-permalink', ['slug' => $artwork->slug]) ?>">
		<figure class="artwork-figure">
			<img src="<?= $this->img($artwork->imageFile, "resizeCrop,320,320,{$crop}|crop,300,300") ?>" width="300" height="300" alt="Previsualización de la obra">
		</figure>

		<header class="artwork-header">
			<div>
				<h2 class="artwork-title">
					<?= str_replace('(', '<br>(', $artwork->title) ?>
				</h2>

				<div class="artwork-info">
					<p>
						<?php
						if ($artwork->artist->count()) {
							foreach ($artwork->artist as $artist) {
								echo "<strong>{$artist->name} {$artist->surname}</strong>";
							}
						} else {
							echo 'Anónimo';
						}
						?>
					</p>

					<?php
					if ($artwork->country) {
						echo $artwork->country->name.', ';
					}

					echo $artwork->year;
					?>
				</div>

				<?php if (!empty($hits)): ?>
				<meter value="<?= $hits[1] ?>" max="<?= $hits[0] ?>" title="<?= $hits[1] ?>"></meter>
				<?php endif ?>
			</div>

			<?php $subtitle = trim(preg_replace('/\s+/u', ' ', $artwork->subtitle)) ?>

			<p class="artwork-subtitle <?= strlen($subtitle) > 100 ? 'is-large' : 'is-short' ?>">
				<?= $subtitle ?>
			</p>
		</header>
	</a>
</article>
