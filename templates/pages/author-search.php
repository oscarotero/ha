<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('author-search'),
	'title' => 'Autores',
	'text' => 'Todos los autores colaboradores de Historia/Arte',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-author-search'
]);

$this->insert('partials/navbar');
?>

<div class="ly-authors">
	<header class="ly-authors-header header">
		<h1>Autores</h1>
	</header>

	<ul class="ly-authors-list author-search-list">
		<?php foreach ($authors as $author): ?>
		<li>
			<?php $this->insert('partials/author/list', compact('author')) ?>
		</li>
		<?php endforeach ?>
	</ul>
</div>
