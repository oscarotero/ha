<?php
if ($artwork->imageCropX === null || $artwork->imageCropY === null) {
	$crop = 'CROP_BALANCE';
} else {
	$crop = "{$artwork->imageCropX}%,{$artwork->imageCropY}%";
}
?>

<article class="artwork is-carrousel" style="
	color: <?= $artwork->foregroundColor ?>;
	background-color: <?= $artwork->backgroundColor ?>;
	">
	<a href="<?= $this->url('artwork-permalink', ['slug' => $artwork->slug]) ?>" title="<?= $artwork->subtitle ?>">
		<figure class="artwork-image">
			<img src="<?= $this->img($artwork->imageFile, "resizeCrop,150,150,{$crop}") ?>" alt="Previsualización de la obra">
		</figure>
		<div class="artwork-content">
			<h2 class="artwork-title">
				<?= $artwork->title ?>
			</h2>

			<p class="artwork-details">
				<?php
				if ($artwork->artist->count()) {
					foreach ($artwork->artist as $artist) {
						echo $artist->name.' '.$artist->surname;
					}
				} else {
					echo 'Anónimo';
				}
				?>, <?= $artwork->year ?>
			</p>
		</div>
	</a>
</article>