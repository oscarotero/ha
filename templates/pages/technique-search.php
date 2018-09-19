<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('technique-search'),
	'title' => 'Técnicas',
	'text' => 'Charlie Chaplin: "El auténtico creador desdeña la técnica entendida como un fin y no como un medio"',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page
]);

$this->insert('partials/navbar');
?>

<main class="ly-techniques">
	<header class="ly-movements-header header">
		<h1>Técnicas</h1>
	</header>

	<ul class="ly-techniques-list technique-list">
		<?php foreach ($techniques as $technique): ?>
		<li>
			<?php $this->insert('partials/technique/list', compact('technique')) ?>
		</li>
		<?php endforeach ?>
	</ul>
</main>
