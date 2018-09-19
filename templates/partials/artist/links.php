<?php
if ($artist->count()) {
	foreach ($artist as $artist) {
		$this->insert('partials/artist/link', compact('artist', 'no_image'));
	}
} else {
	echo <<<HTML
	<span class="artist is-link">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50" height="50">
			<line x1="0" y1="0" x2="50" y2="50"/>
			<line x1="0" y1="50" x2="50" y2="0"/>
		</svg>
		<strong>Anónimo</strong>
	</span>
HTML;
}