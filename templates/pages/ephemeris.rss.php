<?php 
namespace Suin\RSSWriter;

$feed = new Feed();
$channel = new Channel();

$channel
	->title('Artistas - Historia Arte')
	->url($this->url('artist-search'))
	->language('es-ES')
	->pubDate(time())
	->lastBuildDate(time())
	->ttl(60 * 24)
	->appendTo($feed);

foreach ($ephemerises as $ephemeris) {
	$item = new Item();

	$description = strip_tags($ephemeris->text);
	$url = '';

	if (preg_match('/<a href="([^"]+)"/', $ephemeris->text, $match)) {
		$url = $match[1];
	}

	$item
		->title(date('d-m-Y'))
		->description($description)
		->url($url)
		->appendTo($channel);
}

echo $feed;
