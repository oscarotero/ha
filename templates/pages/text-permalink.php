<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('text-permalink', ['slug' => $text->slug]),
	'title' => $text->title,
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', 
	compact('page') + ['bodyClass' => 'has-text-permalink']
);

$this->insert('partials/navbar');
?>

<article class="text is-permalink ly-text">
	<header class="text-header ly-text-header">
		<h1 class="text-title">
			<?= $text->title ?>
		</h1>
	</header>

	<div class="text-body ly-text-body">
		<?php $this->insert('partials/section/sections', ['sections' => $text->body]) ?>
	</div>

	<nav class="text-menu ly-text-menu">
		<ul>
		<?php foreach ($texts as $link): ?>
		<li <?= $link === $text ? 'class="is-selected"' : '' ?>>
			<a href="<?= $this->url('text-permalink', ['slug' => $link->slug]) ?>">
				<?= $link->title ?>
			</a>
		</li>
		<?php endforeach ?>
		</ul>
	</nav>
</article>
