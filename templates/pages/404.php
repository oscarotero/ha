<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('index'),
	'title' => 'Página no encontrada - Error 404'
]);

$this->layout(
	'layouts/default', 
	compact('page') + ['bodyClass' => 'has-error']
);
$this->insert('partials/navbar');
?>

<article class="ly-error error">
	<div class="ly-error-content error-content">
		<h1>No encontramos la página que buscas,</h1>
		<p>La hemos estado buscado pero se ve que no existe</p>
	</div>

	<figure class="ly-error-image error-image">
		<img src="<?= $this->asset('/img/404.jpg') ?>">
	</figure>
</article>
