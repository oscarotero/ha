<?php
$size = $size ?? 80;
$transform = "resizeCrop,{$size},{$size},CROP_ENTROPY";
?>

<article class="artist is-list">
	<a href="<?= $this->url('artist-permalink', ['slug' => $artist->slug]) ?>">
		<div class="artist-image">
			<img src="<?= $this->img($artist->imageFile, $transform) ?>" width="<?= $size ?>" height="<?= $size ?>" alt="Retrato del artista">
		</div>

		<header class="artist-header">
			<h2 class="artist-title">
				<?= $artist->name.' '.$artist->surname ?>
			</h2>
			<p class="artist-details">
				<?php
				if ($artist->country) {
					echo $artist->country->name.', ';
				}

				echo '<span class="util-nowrap">';
				echo $artist->yearBorn ?: '?';

				if ($artist->yearDead) {
					echo '–'.$artist->yearDead;
				}
				echo '</span>';
				?>
			</p>

			<?php if (!empty($hits)): ?>
			<meter value="<?= $hits[1] ?>" max="<?= $hits[0] ?>" title="<?= $hits[1] ?>"></meter>
			<?php endif ?>
		</header>
	</a>
</article>