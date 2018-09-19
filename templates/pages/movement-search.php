<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('movement-search'),
	'title' => 'Movimientos',
	'text' => 'John Berger: "No me gusta hablar de movimientos artísticos. Necesito ver una obra concreta, y mirándola, ver lo que puedo imaginar en ella."',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page
]);

$this->insert('partials/navbar');
?>

<main class="ly-movements">
	<header class="ly-movements-header header">
		<h1>Movimientos</h1>
	</header>

	<ul class="ly-movements-list">
		<?php foreach ($groups as $movements): ?>
			<?php foreach ($movements->movement as $movement): ?>
			<li>
				<?php $this->insert('partials/movement/list', compact('movement')) ?>
			</li>
			<?php endforeach ?>
		<?php endforeach ?>
	</ul>
</main>
