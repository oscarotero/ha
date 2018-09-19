<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('movement-permalink', ['slug' => $movement->slug]),
	'title' => $movement->shareTitle ?: $movement->name,
	'text' => $movement->shareDescription ?: $movement->description,
	'image' => $this->img($movement->imageFile, 'resizeCrop,200,200,CROP_ENTROPY'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'title' => $movement->name,
	'bodyClass' => 'has-movement-permalink'
]);

$this->insert('partials/navbar', [
	'link' => [
		'text' => 'Movimentos',
		'url' => $this->url('movement-search')
	]
]);

$this->insert('partials/movement/permalink', compact('movement', 'artworks', 'artists', 'movements', 'page'));
