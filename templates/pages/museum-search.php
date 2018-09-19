<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('museum-search'),
	'title' => 'Museos',
	'text' => 'Todos los museos de Historia/Arte',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-museum-search'
]);

$this->insert('partials/navbar', [
	'title' => [
		'text' => 'Museos',
		'href' => $this->url('museum-search')
	]
]);
?>

<div class="ly-museums">
	<figure class="ly-museums-map museum-map">
		<div class="js-gmap"></div>
	</figure>

	<ul class="ly-museums-list museum-search-list-countries">
		<?php foreach ($countries as $country): ?>
		<?php
		$cities = $country->city()->orderBy('name')->run();

		if (!$cities->count()) {
			continue;
		}
		?>
		<li class="group">
			<header class="group-header">
				<a href="<?= $this->url('country-permalink', ['slug' => $country->slug]) ?>">
					<h2><?= $country->name ?></h2>
				</a>
			</header>

			<?php $this->insert('partials/museum/list-cities', compact('cities')) ?>
		</li>
		<?php endforeach ?>
	</ul>
</div>
