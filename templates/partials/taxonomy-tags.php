<ul class="taxonomy-tags">
	<?php
	if (!empty($movement) && $movement->count()) {
		foreach ($movement as $each) {
			echo "
				<li>
					<a href=\"{$this->url('movement-permalink', ['slug' => $each->slug])}\">
						<strong>{$each->name}</strong>
					</a>
				</li>
				";
		}
	}

	if (!empty($tag) && $tag->count()) {
		foreach ($tag as $each) {
			echo "
				<li>
					<a href=\"{$this->url('tag-permalink', ['slug' => $each->slug])}\">
						{$each->name}
					</a>
				</li>
				";
		}
	}
	?>
</ul>