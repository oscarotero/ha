<div class="footer-content">
	<nav class="footer-menu">
		<ul>
			<li><a href="<?= $this->url('text-permalink', ['slug' => 'contacto']) ?>">Acerca de HA!</a></li>
			<li><a href="<?= $this->url('artwork-search') ?>">Obras</a></li>
			<li><a href="<?= $this->url('artist-search') ?>">Artistas</a></li>
			<li><a href="<?= $this->url('reportage-search') ?>">Artículos</a></li>
			<li><a href="<?= $this->url('movement-search') ?>">Movimientos</a></li>
			<li><a href="<?= $this->url('technique-search') ?>">Técnicas</a></li>
			<li><a href="<?= $this->url('country-search') ?>">Países</a></li>
			<li><a href="<?= $this->url('museum-search') ?>">Museos</a></li>
		</ul>
	</nav>

	<div class="footer-social">
		<?php $this->insert('partials/social') ?>
	</div>
</div>
