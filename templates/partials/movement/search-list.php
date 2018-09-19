<ul class="movement-search-list">
    <?php foreach ($movements as $movement): ?>
    <li>
        <a href="<?= $this->url('movement-permalink', ['slug' => $movement->slug]) ?>">
            <?= $movement->name ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>
