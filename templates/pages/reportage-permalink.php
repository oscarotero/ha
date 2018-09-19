<?php 
use Spatie\SchemaOrg\Schema;

if ($reportage->imageCropX === null || $reportage->imageCropY === null) {
	$crop = 'CROP_BALANCE';
} else {
	$crop = "{$reportage->imageCropX}%,{$reportage->imageCropY}%";
}

$title = $reportage->title;
$page = new SocialLinks\Page([
	'url' => $this->url('reportage-permalink', ['slug' => $reportage->slug]),
	'title' => $reportage->shareTitle ?: $title,
	'text' => $reportage->shareDescription ?: $reportage->subtitle,
	'image' => $this->img($reportage->shareImageFile ?: $reportage->imageFile, "resize,600,300,{$crop}"),
	'twitterUser' => '@HistoriaArteWeb'
], ['twitter_card_type' => 'summary_large_image']);

$page->html()->addMeta('theme-color', '#fbfaf4');

$schema = Schema::Article()
	->headLine($reportage->title)
	->alternativeHeadline($reportage->subtitle)
	->thumbnailUrl((string) $this->img($reportage->imageFile, 'resize,600,600'))
	->author(Schema::Person()
		->name($reportage->author->name)
	)
	->dateCreated($reportage->createdAt);

$this->layout('layouts/default', compact('page', 'title', 'schema'));

$this->start('extra-header');
?>
<link href="<?= $this->asset("css/reportages/theme-reportage-{$reportage->id}.css") ?>" rel="stylesheet">
<style type="text/css">
	:root {
		--main-image: url('<?= $this->img($reportage->imageFile, "resize,1000") ?>');
	}

	@media (min-width: 1000px) {
		:root {
			--main-image: url('<?= $this->img($reportage->imageFile, "resize,1400") ?>');
		}
	}

	@media (min-width: 1400px) {
		:root {
			--main-image: url('<?= $this->img($reportage->imageFile, "resize,2000") ?>');
		}
	}

	body {
		--background-color: <?= $reportage->backgroundColor ?>;
		--foreground-color: <?= $reportage->foregroundColor ?>;
	}
</style>
<?php $this->stop();

$this->insert('partials/navbar', [
	'link' => [
		'text' => 'Artículos',
		'url' => $this->url('reportage-search')
	]
]);
$this->insert('partials/reportage/permalink', compact('reportage', 'page'));
