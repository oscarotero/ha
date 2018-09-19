<?php foreach ($movements as $movement): ?>
	<a href="<?= $this->url('movement-permalink', ['slug' => $movement->slug]) ?>"><?= $movement->name ?></a>
<?php endforeach ?>
