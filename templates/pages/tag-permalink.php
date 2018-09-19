<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('tag-permalink', ['slug' => $tag->slug]),
	'title' => $tag->name,
	'text' => "Obras y artistas etiquetados como '{$tag->name}'",
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'title' => $tag->name,
	'bodyClass' => 'has-tag-permalink'
]);

$this->insert('partials/navbar', [
	'title' => "Etiqueta <em>&ldquo;{$tag->name}&rdquo;</em>"
]);

$this->insert('partials/tag/permalink', compact('tag', 'artworks', 'artists', 'reportages'));
