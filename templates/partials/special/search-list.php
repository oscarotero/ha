
<ul class="special-search-list">
    <?php foreach ($specials as $special): ?>
    <li>
        <a href="<?= $this->url('special-permalink', ['slug' => $special->slug]) ?>">
            <strong><?= $special->name ?></strong>
            <br>
            <time datetime="<?= $special->startsAt->format(DateTime::ISO8601) ?>"><?= $special->startsAt->format('d') ?></time>–<time datetime="<?= $special->endsAt->format(DateTime::ISO8601) ?>"><?= $special->endsAt->format('d') ?> de <?= $this->month($special->endsAt) ?>. <?= $special->endsAt->format('Y') ?></time>
        </a>
    </li>
    <?php endforeach ?>
</ul>
