<ul class="museum-search-list">
    <?php foreach ($museums as $museum): ?>
    <li>
        <a href="<?= $this->url('museum-permalink', ['slug' => $museum->slug]) ?>"
           class="js-gmap-point"
           data-coords="<?= json_encode($museum->location) ?>"
           title="<?= $museum->name ?>">
            <?= $museum->name ?>

            <?php
            if (!empty($full)) {
              echo "({$museum->city->name})";
            }
            ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>