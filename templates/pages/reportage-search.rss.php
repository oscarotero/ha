<?php 
namespace Suin\RSSWriter;

$feed = new Feed();
$channel = new Channel();

$channel
	->title('Artículos - Historia Arte')
	->url($this->url('reportage-search'))
	->language('es-ES')
	->pubDate(time())
	->lastBuildDate(time())
	->ttl(60)
	->pubsubhubbub($this->url('reportage-search.rss'), 'http://pubsubhubbub.appspot.com')
	->appendTo($feed);

$filter = [];

if ($tag) {
	$filter[] = "etiquetados como {$tag->name}";
}
if ($author) {
	$filter[] = "escritos por {$author->name}";
}

if ($filter) {
	$channel->description('Filtrando solo por artículos '.ViewHelpers\Text::join($filter));
}

foreach ($reportages as $reportage) {
	$item = new Item();
	$img = $this->img($reportage->imageFile, 'resize,300');
	$url = $this->url('reportage-permalink', ['slug' => $reportage->slug]);
	$description = <<<EOT
<p>
	{$reportage->subtitle}
</p>
<a href="{$url}">
	<img src="{$img}">
</a>
EOT;

	$item
		->title($reportage->title)
		->description($description)
		->url($url)
		->author($reportage->author->name)
		->pubDate($reportage->publishedAt->getTimestamp())
		->appendTo($channel);
}

echo $feed;
