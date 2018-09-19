<?php 
namespace Suin\RSSWriter;

$feed = new Feed();
$channel = new Channel();

$channel
	->title('Obras - Historia Arte')
	->url($this->url('artwork-search'))
	->language('es-ES')
	->pubDate(time())
	->lastBuildDate(time())
	->ttl(60)
	->appendTo($feed);


foreach ($artworks as $artwork) {
	$item = new Item();
	$item
		->title($artwork->title)
		->description($artwork->$rrss)
		->url($this->url('artwork-permalink', ['slug' => $artwork->slug]))
		->author($artwork->author->name)
		->pubDate($artwork->publishedAt->getTimestamp())
		->appendTo($channel);
}

echo $feed;
