<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('index'),
	'title' => 'Sin conexión - HA!'
]);

$this->layout(
	'layouts/default', 
	compact('page') + ['bodyClass' => 'has-error']
);
$this->insert('partials/navbar');
?>

<article class="ly-error error">
	<div class="ly-error-content error-content">
		<h1>No tienes conexión a internet</h1>
		<p>Comprueba que no has pisado ningún cable y que estas en un sitio con cobertura</p>
	</div>

	<figure class="ly-error-image error-image">
		<img src="<?= $this->asset('/img/503.jpg') ?>">
	</figure>
</article>
