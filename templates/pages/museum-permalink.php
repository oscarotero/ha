<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('museum-permalink', ['slug' => $museum->slug]),
	'title' => $museum->name,
	'text' => 'Obras de este museo',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'title' => $museum->name,
	'bodyClass' => 'has-museum-permalink'
]);

$this->insert('partials/navbar', [
	'link' => [
		'text' => 'Museos',
		'url' => $this->url('museum-search')
	]
]);
$this->insert('partials/museum/permalink', compact('museum', 'artworks', 'museums', 'page'));
