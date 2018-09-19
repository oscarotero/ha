<ul class="tag-search-list">
    <?php foreach ($tags as $tag): ?>
    <li>
        <a href="<?= $this->url('tag-permalink', ['slug' => $tag->slug]) ?>">
            <?= $tag->name ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>