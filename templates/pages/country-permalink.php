<?php
$page = new SocialLinks\Page([
	'url' => $this->url('country-permalink', ['slug' => $country->slug]),
	'title' => $country->name,
	'text' => 'Obras y artistas nacidos en este país',
	'image' => $country->imageFile ? $this->img($country->imageFile, 'resizeCrop,600,300') : $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'title' => $country->name,
	'bodyClass' => 'has-country-permalink'
]);

$this->insert('partials/navbar', [
	'title' => $country->name,
	'link' => [
		'text' => 'Países',
		'url' => $this->url('country-search')
	]
]);
$this->insert('partials/country/permalink', compact('country', 'artworks', 'artists'));
