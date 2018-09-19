<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('country-search'),
	'title' => 'Países',
	'text' => '',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page
]);

$this->insert('partials/navbar');
?>

<main class="ly-countries">
	<header class="ly-countries-header header">
		<h1>Países</h1>
	</header>

	<ul class="ly-countries-list country-list">
		<?php foreach ($countries as $country): ?>
		<li>
			<?php $this->insert('partials/country/list', compact('country')) ?>
		</li>
		<?php endforeach ?>
	</ul>
</main>
