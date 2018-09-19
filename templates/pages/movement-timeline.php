<?php 
$page = new SocialLinks\Page([
	'url' => $this->url('movement-search'),
	'title' => 'Movimientos',
	'text' => 'John Berger: "No me gusta hablar de movimientos artísticos. Necesito ver una obra concreta, y mirándola, ver lo que puedo imaginar en ella."',
	'image' => $this->asset('img/rrss.jpg'),
	'twitterUser' => '@HistoriaArteWeb'
]);

$page->html()->addMeta('theme-color', '#fbfaf4');

$this->layout('layouts/default', [
	'page' => $page,
	'menu' => 'movement',
	'bodyClass' => 'has-movements-timeline'
]);

$this->insert('partials/navbar', [
	'title' => 'Movimientos'
]);
?>

<div class="ly-movements-timeline">
	<div class="movements-timeline-years ly-movements-timeline-header">
		<?php 
		for ($year = 1300; $year < 2000; $year += 10) { 
			echo "<strong>{$year}</strong>";
		}
		?>
	</div>
	<ul class="movements-timeline-content ly-movements-timeline-content">
		<?php
		$k = 1;
		foreach ($movements as $movement) {
			echo ViewHelpers\Html::element('li', [
				'style' => [
					'grid-column-start' => $movement->yearStart - 1300 + 1,
					'grid-column-end' => $movement->yearEnd ? 'span '.($movement->yearEnd - $movement->yearStart) : 700,
					'grid-row-start' => $k++
				]
			]);
			$this->insert('partials/movement/timeline', compact('movement'));
			echo '</li>';
		}
		?>
	</ul>
</div>