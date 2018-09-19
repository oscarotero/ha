<?php 
use Spatie\SchemaOrg\Schema;

$title = $artist->name.' '.$artist->surname;

$description = $artist->yearBorn.implode(
	array_map(
		function ($section) {
			return $section['text'];
		},
		array_filter($artist->body, function ($section) {
			return $section['type'] === 'text';
		})
	)
);

$page = new SocialLinks\Page([
	'url' => $this->url('artist-permalink', ['slug' => $artist->slug]),
	'title' => $artist->shareTitle ?: $title,
	'text' => $artist->shareDescription ?: $description,
	'image' => $this->img($artist->imageFile, 'resizeCrop,200,200,CROP_ENTROPY'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$schema = Schema::Person()
	->name($title)
	->image((string) $this->img($artist->imageFile, 'resize,600,600'));

$this->layout('layouts/default', 
	compact('page', 'title', 'schema') + ['bodyClass' => 'has-artist-permalink']
);
$this->insert('partials/navbar', [
	'link' => [
		'text' => 'Artistas',
		'url' => $this->url('artist-search').'?page=1'
	]
]);
$this->insert('partials/artist/permalink', compact('artist', 'layout', 'related', 'page'));
