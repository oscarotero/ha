<ul class="museum-related-list">
	<?php foreach ($cities as $city): ?>
	<?php
	$museums = $city->museum()->orderBy('name')->run();

	if (!$museums->count()) {
		continue;
	}
	?>
	<li class="museum-search-list-city">
		<h3><?= $city->name ?>:</h3>

		<?php $this->insert('partials/museum/search-list', compact('museums')) ?>
	</li>
	<?php endforeach ?>
</ul>