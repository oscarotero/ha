<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('special-permalink', ['slug' => $special->slug]),
	'title' => $special->name,
	'text' => $special->description,
	//'image' => $this->img($special->imageFile, 'resizeCrop,200,200,CROP_ENTROPY'),
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'title' => $special->name,
	'bodyClass' => 'has-special-permalink'
]);

$this->insert('partials/navbar', [
	'title' => "Semana especial"
]);

$this->insert('partials/special/permalink', compact('special', 'artworks', 'reportages', 'specials', 'page'));
