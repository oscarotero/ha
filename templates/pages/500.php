<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('index'),
	'title' => 'Error - HA!'
]);

$this->layout(
	'layouts/default', 
	compact('page') + ['bodyClass' => 'has-error']
);
$this->insert('partials/navbar');
?>

<article class="ly-error error">
	<div class="ly-error-content error-content">
		<h1>¡Dios mío, se ha producido un error!</h1>
		<p>En el mundo del arte nada es perfecto</p>
	</div>

	<figure class="ly-error-image error-image">
		<img src="<?= $this->asset('/img/500.jpg') ?>">
	</figure>
</article>
