<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('artwork-search'),
	'title' => 'Obras',
	'text' => 'Henry Moore: "El misterio es el elemento clave de las obras de arte. No conozco ninguna buena obra de arte que no tenga misterio"',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-artwork-search'
]);

$this->insert('partials/navbar');
?>

<?php if (!empty($trending)): ?>
<main class="ly-trendings">
	<section class="group ly-trendings-content">
		<header class="group-header">
			<a href="?page=1">
				<h2>Obras <em>populares hoy</em></h2>

				<span class="button-icon">
					<?php $this->insert('partials/icons/plus') ?>
				</span>
			</a>
		</header>

		<ul class="artwork-related-list">
			<?php $max = null ?>
			<?php foreach ($trending as $trendingArtwork): ?>
			<?php $max = $max ?: $trendingArtwork['hits'] ?>
			<li>
				<?php $this->insert('partials/artwork/list', [
					'artwork' => $trendingArtwork['row'],
					'hits' => [$max, $trendingArtwork['hits']]
				]) ?>
			</li>
			<?php endforeach ?>
		</ul>
	</section>
</main>

<?php return; ?>
<?php endif ?>

<main class="ly-search artwork-search">
	<nav class="ly-search-form">
		<div class="searchForm-header">
			<h2>Filtrar <em>obras</em></h2>
		</div>

		<?php
		echo $form
			->addClass('searchForm js-filter')
			->data(['target-selector' => '#search-result'])
			->openHtml();

		$form['age']->setElementName('details', true);
		$form['age']->attr('open', !empty($form['age']->val()));

		echo $form['age']
			->addClass('searchForm-group has-radio')
			->toHtml('<summary class="searchForm-subtitle">Año</summary>', $form['decade']);

		$form['movement']->wrapper->setElementName('details', true);
		$form['movement']->wrapper->attr('open', !empty($form['movement']->val()));

		echo $form['movement']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Movimiento</summary>');

		$form['technique']->wrapper->setElementName('details', true);
		$form['technique']->wrapper->attr('open', !empty($form['technique']->val()));

		echo $form['technique']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Técnica</summary>');

		$form['country']->wrapper->setElementName('details', true);
		$form['country']->wrapper->attr('open', !empty($form['country']->val()));

		echo $form['country']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">País</summary>');

		$form['museum']->wrapper->setElementName('details', true);
		$form['museum']->wrapper->attr('open', !empty($form['museum']->val()));

		echo $form['museum']
			->addClass('js-trending')
			->wrapperAttr(['class' => 'searchForm-group'])
			->toHtml('<summary class="searchForm-subtitle">Museo</summary>');

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
			->toHtml('<summary class="searchForm-subtitle">Etiqueta</summary>');

		$form['order']->setElementName('details', true);
		$form['order']->attr('open', !empty($form['order']->val()));

		echo $form['order']
			->addClass('searchForm-group has-radio')
			->toHtml('<summary class="searchForm-subtitle">Ordenar por</summary>');

		echo $form['']
			->wrapperAttr([
				'class' => 'searchForm-submit '.(empty($trending) ? 'js-hidden' : '')
			]);

		echo $form->closeHtml();
		?>
	</nav>

	<div class="ly-search-result" id="search-result">
		<?php if (count($artworks)): ?>
		<ul class="artwork-search-list">
			<?php foreach ($artworks as $artwork): ?>
			<li>
				<?php $this->insert('partials/artwork/list', compact('artwork')) ?>
			</li>
			<?php endforeach ?>
		</ul>
		<?php
		$this->insert('partials/pagination', [
			'model' => $artworks,
			'form' => $form,
			'target' => '#search-result'
		]);
		?>
		<?php else: ?>
		<section class="emptyState">
			<p>
				<strong>No hemos encontrado obras con estas características</strong>
			</p>
			<p>
				Si echas alguna obra en falta, puedes enviarnos una sugerencia a <a href="mailto:info@historia-arte.com">info@historia-arte.com</a>
			</p>
		</section>
		<?php endif ?>
	</div>
</main>
