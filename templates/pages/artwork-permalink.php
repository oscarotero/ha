<?php 
use Spatie\SchemaOrg\Schema;
use ViewHelpers\Html;

//Metadata
if ($artwork->imageCropX === null || $artwork->imageCropY === null) {
	$crop = 'CROP_BALANCE';
} else {
	$crop = "{$artwork->imageCropX}%,{$artwork->imageCropY}%";
}

$title = $artwork->title;

if ($artwork->artist->count()) {
	$title .= ' - '.implode(
		', ',
		array_map(
			function ($artist) {
				return $artist->name.' '.$artist->surname;
			},
			$artwork->artist->toArray(false)
		)
	);
} else {
	$title .= ' - Anónimo';
}

$page = new SocialLinks\Page([
	'url' => $this->url('artwork-permalink', ['slug' => $artwork->slug]),
	'title' => $artwork->shareTitle ?: $title,
	'text' => $artwork->shareDescription ?: $artwork->subtitle,
	'image' => $this->img($artwork->shareImageFile ?: $artwork->imageFile, "resizeCrop,600,300,{$crop}"),
	'twitterUser' => '@HistoriaArteWeb'
], ['twitter_card_type' => 'summary_large_image']);

$page->html()->addMeta('theme-color', $artwork->backgroundColor ?: '#fbfaf4');

//Schema
$schema = Schema::VisualArtwork()
	->headLine($artwork->title)
	->thumbnailUrl((string) $this->img($artwork->imageFile, 'resize,600,600'))
	->dateCreated($artwork->createdAt);

$artwork->artist->rewind();

if ($artist = $artwork->artist->current()) {
	$schema->author(Schema::person()
		->name($artist->name.' '.$artist->surname)
	);
}

$this->start('extra-header');
echo <<<EOT
<style>
body {
	--background-color:{$artwork->backgroundColor};
	--foreground-color:{$artwork->foregroundColor};
}
</style>
EOT;
$this->stop();

//Layout
if ($artwork->imageWidth && $artwork->imageHeight) {
	$ratio = round(($artwork->imageWidth/$artwork->imageHeight) * 100, 2);
} else {
	$ratio = null;
}

if (!empty($artwork->images)) {
	$layout = 200;
} else {
	$layouts = [
		50 => [1, 62.5],
		75 => [62.5, 87.5],
		100 => [87.5, 112.5],
		125 => [112.5, 137.5],
		150 => [137.5, 162.5],
		175 => [162.5, 187.5],
		200 => [187.5],
	];

	foreach ($layouts as $layout => $range) {
		if ($ratio >= $range[0] && (!isset($range[1]) || $ratio < $range[1])) {
			break;
		}
	}
}
$bodyClass = "has-ly-{$layout}";

$this->layout('layouts/default', compact('page', 'schema', 'title', 'bodyClass'));
$this->insert('partials/navbar');
$this->insert('partials/artwork/permalink', compact('artwork', 'layout', 'ratio', 'page'));
?>

<?php $this->start('extra-footer') ?>
<aside class="artwork-related-group">
	<div class="carousel-wrapper has-artwork">
		<ha-carousel data-carousel-width="300" role="region" aria-label="Obras relacionadas" tabindex="0">
			<?php
			foreach ($related as $related) {
				$this->insert('partials/artwork/list', ['artwork' => $related]);
			}
			?>
		</ha-carousel>
	</div>
</aside>
<?php $this->stop() ?>