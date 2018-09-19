<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('reportage-search'),
	'title' => 'Artículos',
	'text' => 'Bukowski: "Un intelectual es el que dice una cosa simple de un modo complicado. Un artista es el que dice una cosa complicada de un modo simple"',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-reportage-search'
]);

$this->insert('partials/navbar', [
	'title' => 'Artículos'
]);
?>

<?php $this->start('extra-header') ?>
<link rel="alternate" type="application/rss+xml" title="Últimos artículos publicados" href="<?= $this->url('reportage-search.rss') ?>">
<style type="text/css">
	body {
		--background-color: white;
	}
</style>
<?php $this->stop() ?>

<main class="ly-reportages">
	<ul class="ly-reportages-list">
		<?php foreach ($reportages as $reportage): ?>
		<li>
			<?php $this->insert('partials/reportage/card', compact('reportage')) ?>
		</li>
		<?php endforeach ?>
	</ul>
</main>
