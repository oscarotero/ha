<?php foreach ($techniques as $technique): ?>
	<a href="<?= $this->url('technique-permalink', ['slug' => $technique->slug]) ?>"><?= $technique->name ?></a>
<?php endforeach ?>
