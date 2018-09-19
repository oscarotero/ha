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
	->ttl(60)
	->pubsubhubbub($this->url('artist-search.rss'), 'http://pubsubhubbub.appspot.com')
	->appendTo($feed);


foreach ($artists as $artist) {
	$item = new Item();
	$img = $this->img($artist->imageFile, 'resize,300');
	$url = $this->url('artist-permalink', ['slug' => $artist->slug]);
	$description = <<<EOT
<p>
	{$artist->yearBorn}
</p>
<a href="{$url}">
	<img src="{$img}">
</a>
EOT;

	$item
		->title($artist->name.' '.$artist->surname)
		->description($description)
		->url($url)
		->appendTo($channel);
}

echo $feed;
