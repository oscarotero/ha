<?php
$title = $author->name;

if ($author->title) {
	$title .= " - {$author->title}";
}

$page = new SocialLinks\Page([
	'url' => $this->url('author-permalink', ['slug' => $author->slug]),
	'title' => $title,
	'text' => $author->bio,
	'image' => $author->imageFile ? $this->img($author->imageFile, 'resizeCrop,600,300') : $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', compact('page', 'title') + [
	'bodyClass' => 'has-author-permalink'
]);

$this->insert('partials/navbar', [
	'link' => [
		'text' => 'Autores',
		'url' => $this->url('author-search')
	]
]);
$this->insert('partials/author/permalink', compact('author', 'artworks', 'artists', 'reportages'));
