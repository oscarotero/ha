<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('artist-search'),
	'title' => 'Artistas',
	'text' => 'Wassily Kandinski: "El artista es la mano que, mediante una y otra tecla, hace vibrar adecuadamente el alma humana"',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-artist-search'
]);

$size = 200;

$this->insert('partials/navbar');
?>

<?php if (!empty($trending)): ?>
<main class="ly-trendings">
	<section class="group ly-trendings-content">
		<header class="group-header">
			<a href="?page=1">
				<h2>Artistas <em>populares hoy</em></h2>

				<span class="button-icon">
					<?php $this->insert('partials/icons/plus') ?>
				</span>
			</a>
		</header>

		<ul class="artist-related-list">
			<?php $max = null ?>
			<?php foreach ($trending as $trendingArtist): ?>
			<?php $max = $max ?: $trendingArtist['hits'] ?>
			<li>
				<?php $this->insert('partials/artist/list', [
					'artist' => $trendingArtist['row'],
					'hits' => [$max, $trendingArtist['hits']]
				]) ?>
			</li>
			<?php endforeach ?>
		</ul>
	</section>
</main>

<?php return; ?>
<?php endif ?>


<main class="ly-search artist-search">
	<nav class="ly-search-form">
		<div class="searchForm-header">
			<h2>Filtrar <em>artistas</em></h2>
		</div>

		<?php
		echo $form
			->addClass('searchForm')
			->data(['target-selector' => '#search-result'])
			->openHtml();

		$form['life']->setElementName('details', true);
		$form['life']->attr('open', !empty($form['life']->val()));

		echo $form['life']
			->addClass('searchForm-group has-radio')
			->toHtml('<summary class="searchForm-subtitle">Año</summary>', $form['year']);

		$form['movement']->wrapper->setElementName('details', true);
		$form['movement']->wrapper->attr('open', !empty($form['movement']->val()));

		echo $form['movement']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Movimientos</summary>');


		$form['country']->wrapper->setElementName('details', true);
		$form['country']->wrapper->attr('open', !empty($form['country']->val()));

		echo $form['country']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Países</summary>');

		$form['author']->wrapper->setElementName('details', true);
		$form['author']->wrapper->attr('open', !empty($form['author']->val()));

		echo $form['author']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Escrito por</summary>');

		$form['tag']->wrapper->setElementName('details', true);
		$form['tag']->wrapper->attr('open', !empty($form['tag']->val()));

		echo $form['tag']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Etiquetas</summary>');

		//echo $form['genre']->addClass('searchForm-group has-radio');

		$form['order']->setElementName('details', true);
		$form['order']->attr('open', !empty($form['order']->val()));

		echo $form['order']
			->addClass('searchForm-group has-radio')
			->toHtml('<summary class="searchForm-subtitle">Orden</summary>');

		echo $form['']
			->addClass('button')
			->wrapperAttr([
				'class' => 'searchForm-submit '.(empty($trending) ? 'js-hidden' : '')
			]);

		echo $form->closeHtml();
		?>
	</nav>

	<div class="ly-search-result" id="search-result">
		<?php if (count($artists)): ?>
		<ul class="artist-search-list">
			<?php foreach ($artists as $artist): ?>
			<li>
				<?php $this->insert('partials/artist/list', compact('artist', 'size')) ?>
			</li>
			<?php endforeach ?>
		</ul>
		<?php
		$this->insert('partials/pagination', [
			'model' => $artists,
			'form' => $form,
			'target' => '#search-result'
		]);
		?>
		<?php else: ?>
		<section class="emptyState">
			<h2>No hemos encontrado artistas con estas características</h2>
			<p>
				Si echas en falta a algún artista, puedes enviarnos una sugerencia a <a href="mailto:info@historia-arte.com">info@historia-arte.com</a>
			</p>
		</section>
		<?php endif ?>
	</div>
</main>
