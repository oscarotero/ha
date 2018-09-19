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


foreach ($reportages as $reportage) {
	$item = new Item();
	$item
		->title($reportage->title)
		->description($reportage->$rrss)
		->url($this->url('reportage-permalink', ['slug' => $reportage->slug]))
		->author($reportage->author->name)
		->pubDate($reportage->publishedAt->getTimestamp())
		->appendTo($channel);
}

echo $feed;
