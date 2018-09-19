<?php 
$title = $technique->name;

$page = new SocialLinks\Page([
	'url' => $this->url('technique-permalink', ['slug' => $technique->slug]),
	'title' => $technique->shareTitle ?: $title,
	'text' => $technique->shareDescription ?: $technique->description,
	'image' => $this->img($technique->imageFile, 'resizeCrop,200,200,CROP_ENTROPY'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', 
	compact('page', 'title') + ['bodyClass' => 'has-technique-permalink']
);

$this->insert('partials/navbar', [
	'link' => [
		'text' => 'Técnicas',
		'url' => $this->url('technique-search')
	]
]);

$this->insert('partials/technique/permalink', compact('technique', 'artworks', 'page'));
