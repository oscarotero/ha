<?php foreach ($tags as $tag): ?>
	<a href="<?= $this->url('tag-permalink', ['slug' => $tag->slug]) ?>"><?= $tag->name ?></a>
<?php endforeach ?>
