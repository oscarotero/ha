<article class="reportage is-highlight">
	<a href="<?= $this->url('reportage-permalink', ['slug' => $reportage->slug]) ?>">
		<figure class="reportage-image">
			<?php
				if ($reportage->imageCropX === null || $reportage->imageCropY === null) {
				$crop = 'CROP_BALANCE';
			} else {
				$crop = "{$reportage->imageCropX}%,{$reportage->imageCropY}%";
			}

			echo ViewHelpers\Html::picture(
				[
					$this->img($reportage->imageFile, "resizeCrop,500,400,{$crop}"),
					'(min-width:1500px)' => $this->img($reportage->imageFile, "resizeCrop,2000,800,{$crop}"),
					'(min-width:1000px)' => $this->img($reportage->imageFile, "resizeCrop,1500,800,{$crop}"),
					'(min-width:500px)' => $this->img($reportage->imageFile, "resizeCrop,1000,600,{$crop}"),
				],
				$reportage->title
			);
			?>
		</figure>

		<header class="reportage-header">
			<h1 class="reportage-title">
				<?= $reportage->title ?>
			</h1>
			
			<p class="reportage-subtitle">
				<?= $reportage->subtitle ?>
			</p>
		</header>
	</a>
</article>