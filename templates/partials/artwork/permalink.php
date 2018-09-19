<?php
$gallery = !empty($artwork->images);

if ($artwork->year < 1800) {
	//$class .= ' is-old';
}

if (!empty($artwork->code) || !empty($artwork->widget)) {
	$layout = 200;
}
?>

<article class="artwork is-permalink ly-artwork is-<?= $layout ?>" style="--image-ratio:<?= $ratio ?>vh;">
	<div class="artwork-figures ly-artwork-figure <?= $gallery ? 'carousel-wrapper' : '' ?>">
		<?php
		$sizes = ['resize,500', 'resize,1000', 'resize,1500', 'resize,2000', 'resize,2500'];

		if (!empty($artwork->code)) {
			$this->insert('partials/artwork/figures/video', ['code' => $artwork->code]);
		} elseif (!empty($artwork->widget)) {
			$this->insert('partials/widget', ['name' => $artwork->widget]);
		} elseif ($gallery) {
			$this->insert('partials/artwork/figures/gallery', [
				'firstImage' => $artwork->imageFile,
				'firstImageCaption' => $artwork->caption,
				'images' => $artwork->images,
				'sizes' => $sizes,
			]);
		} else {
			$this->insert('partials/artwork/figures/image', [
				'image' => $artwork->imageFile,
				'sizes' => $sizes,
				'caption' => $artwork->caption
			]);
		}
		?>
	</div>

	<header class="artwork-header ly-artwork-header">
		<h1 class="artwork-title">
			<?= str_replace('(', '<br>(', $artwork->title) ?>
		</h1>

		<p class="artwork-subtitle">
			<?= preg_replace('/\s+/u', ' ', $artwork->subtitle) ?>
		</p>

		<div class="artwork-info">
			<p>
				<?php $this->insert('partials/artist/links', ['artist' => $artwork->artist]); ?>
			</p>

			<?php
			if ($artwork->country) {
				echo "<a href=\"{$this->url('country-permalink', ['slug' => $artwork->country->slug])}\">{$artwork->country->name}</a>, ";
			}

			echo $artwork->year;
			?>
		</div>
	</header>

	<div class="ly-artwork-nav artwork-details">
		<footer class="artwork-footer taxonomy">
			<?php
			$this->insert('partials/taxonomy-tags', [
				'movement' => $artwork->movement,
				'tag' => $artwork->tag
			]);
			?>

			<ul class="taxonomy-info">
				<?php
				if ($artwork->originalTitle) {
					echo "<li><strong>Título original:</strong> {$artwork->originalTitle}</li>";
				}
				?>

				<?php
				if ((string) $artwork->museum) {
					echo '<li>';

					if ((string) $artwork->museum->city) {
						echo "<strong>Museo:</strong>
						<a href=\"{$this->url('museum-permalink', ['slug' => $artwork->museum->slug])}\">
							{$artwork->museum->name}, {$artwork->museum->city->name} ({$artwork->museum->city->country->name})
						</a>
						";
					} else {
						echo "<strong>{$artwork->museum->name}</strong>";
					}

					echo '</li>';
				}

				if ($artwork->technique->count()) {
					echo '<li>';
					echo '<strong>Técnica:</strong>';
					foreach ($artwork->technique as $technique) {
						echo "<a href=\"{$this->url('technique-permalink', ['slug' => $technique->slug])}\">
							{$technique->name}</a>";
					}

					if ($artwork->size) {
						echo " ({$artwork->size})";
					}
					echo '</li>';
				} elseif ($artwork->size) {
					echo '<li>';
					echo $artwork->size;
					echo '</li>';
				}

				if ($artwork->description) {
					echo '<li>';
					echo $artwork->description;
					echo '</li>';
				}

				if ($artwork->author) {
					echo '<li>';
					echo "<strong>Escrito por:</strong>
							<a href=\"{$this->url('author-permalink', ['slug' => $artwork->author->slug])}\">
								{$artwork->author->name}
							</a>
						";
					echo '</li>';
				}
				?>
			</ul>
		</footer>
	</div>

	<div class="artwork-body ly-artwork-content">
		<?php $this->insert('partials/section/sections', ['sections' => $artwork->body]) ?>
		<?php $this->insert('partials/collaborate') ?>
	</div>
</article>
