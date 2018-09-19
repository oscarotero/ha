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
	->pubsubhubbub($this->url('artwork-search.rss'), 'http://pubsubhubbub.appspot.com')
	->appendTo($feed);


foreach ($artworks as $artwork) {
	$item = new Item();
	$img = $this->img($artwork->imageFile, 'resize,300');
	$url = $this->url('artwork-permalink', ['slug' => $artwork->slug]);
	$description = <<<EOT
<p>
	{$artwork->subtitle}
</p>
<a href="{$url}">
	<img src="{$img}">
</a>
EOT;

	$item
		->title($artwork->title)
		->description($description)
		->url($url)
		->author($artwork->author->name)
		->pubDate($artwork->publishedAt->getTimestamp())
		->appendTo($channel);
}

echo $feed;
