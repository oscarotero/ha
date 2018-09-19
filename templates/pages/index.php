<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('index'),
	'title' => 'Portada',
	'text' => 'La web de la historia del arte y los artistas. Conoce las mejores obras de arte y a sus creadores. Una obra de arte al día.',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'bodyClass' => 'has-index'
]);

?>

<?php $this->start('extra-header') ?>
<link rel="alternate" type="application/rss+xml" title="Últimas obras añadidas" href="<?= $this->url('artwork-search.rss') ?>">
<link rel="alternate" type="application/rss+xml" title="Últimos artículos publicados" href="<?= $this->url('reportage-search.rss') ?>">
<link rel="alternate" type="application/rss+xml" title="Últimos artistas añadidos" href="<?= $this->url('artist-search.rss') ?>">
<?php $this->stop() ?>

<?php
$this->insert('partials/navbar');

if ($artwork) {
	$backgroundColor = $artwork->backgroundColor ?: 'white';
	$foregroundColor = $artwork->foregroundColor ?: 'black';
} elseif ($reportage) {
	$backgroundColor = $reportage->backgroundColor ?: 'white';
	$foregroundColor = $reportage->foregroundColor ?: 'black';
}

$this->start('extra-header');
echo <<<EOT
<style>
body {
	--background-color:{$backgroundColor};
	--foreground-color:{$foregroundColor};
}
</style>
EOT;
$this->stop();
?>

<main class="ly-home">
	<div class="ly-home-content">
	<?php
	if ($artwork) {
		$this->insert('partials/artwork/highlight', compact('artwork'));
	} else {
		$this->insert('partials/reportage/highlight', compact('reportage'));
	}
	
	if ($ephemeris) {
		$this->insert('partials/ephemeris', compact('ephemeris'));
	}
	?>
	</div>

	<section class="ly-home-subscribe subscription">
		<div>
			<a href="http://eepurl.com/cCHEX1" class="subscription-newsletter button">Recibe tu dosis HA! cada día en tu mail</a>
		</div>
	</section>
</main>

<?php $this->start('extra-footer') ?>
<aside class="artwork-related-group">
	<div class="carousel-wrapper has-artwork">
		<ha-carousel data-carousel-width="300" role="region" aria-label="Últimas obras comentadas" tabindex="0">
			<?php
			foreach ($artworks as $related) {
				$this->insert('partials/artwork/list', ['artwork' => $related]);
			}
			?>
		</ha-carousel>
	</div>
</aside>
<?php $this->stop() ?>