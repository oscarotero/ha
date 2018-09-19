<nav class="navbar">
	<div class="navbar-main">
		<?php if (!empty($link)): ?>
		<a href="<?= $link['url'] ?>" class="navbar-link">
			<?php $this->insert('partials/icons/plus') ?>
			<strong><?= $link['text'] ?></strong>
		</a>
		<?php endif ?>

		<a href="<?= $this->url('index') ?>" class="navbar-logo">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 200" width="42" height="24">
				<title>Historia/Arte (HA!)</title>
				<rect x="300" y="150" width="50" height="50"/>
				<rect x="300" width="50" height="120"/>
				<path d="M240,200h60L190,0H110V80H50V0H0V200H50V120h60v80h50V160h60Zm-80-80V40l40,80Z"/>
			</svg>
		</a>
	</div>

	<?php 
	$icon = $this->fetch('partials/icons/search');

	$searchForm = App\Forms::search();
	$searchForm['']->html($icon.' <span class="util-visuallyhidden">Buscar</span>');

	echo $searchForm->attr([
		'action' => $this->url('search'),
		'class' => 'navbar-search js-search search-form'
	])->openHtml();
	echo '<div class="search-form-content">';
	echo $searchForm['q']->label;
	echo $searchForm['q']->input->addClass('search-form-input js-search-input');
	echo $searchForm['']->input->addClass('search-form-submit');
	echo '</div>';
	?>
	<button type="button" class="search-form-close js-search-close">
		<?= $this->insert('partials/icons/close') ?><span class="util-visuallyhidden">Cerrar</span>
	</button>
	<div class="search-results">
		<div class="search-results-container js-results">
		</div>
	</div>
	<?= $searchForm->closeHtml(); ?>
</nav>
