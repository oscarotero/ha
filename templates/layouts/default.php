<!DOCTYPE html>
<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title><?= $title ?? $page->getTitle() ?> - Historia Arte (HA!)</title>
        <link href="<?= $this->asset('css/styles.css') ?>" rel="stylesheet">
        <link href="<?= $this->asset('/apple-touch-icon.png') ?>" rel="apple-touch-icon">
        <link href="<?= $this->asset('/favicon-32x32.png') ?>" rel="icon" type="image/png" sizes="32x32">
        <link href="<?= $this->asset('/favicon-16x16.png') ?>" rel="icon" type="image/png" sizes="16x16">
        <link href="<?= $this->asset('/manifest.webmanifest') ?>" rel="manifest">
        <link href="<?= $this->asset('/safari-pinned-tab.svg') ?>" color="#333" rel="mask-icon">
        <link href="<?= $this->asset('humans.txt') ?>" rel="author">
        <meta name="google-site-verification" content="B9igI_F_R6dO5br1iQ0C9rJyDHWBUCQerJZ7FwEm2as" />
        <meta property="og:site_name" content="HA!">
        <meta property="og:locale" content="es_ES">
        <meta property="fb:app_id" content="215855945485224">

        <?php
        foreach ($page->openGraph() as $k => $meta) {
            echo $meta;
        }
        foreach ($page->twitterCard() as $meta) {
            echo $meta;
        }
        foreach ($page->schema() as $meta) {
            echo $meta;
        }
        foreach ($page->html() as $meta) {
            echo $meta;
        }

        echo $this->section('extra-header');
        ?>

        <script src="<?= $this->asset('js/polyfills.js') ?>" async></script>
        <script type="module" src="<?= $this->asset('js/main.js') ?>"></script>

        <?php 
        if (!empty($schema)) {
            echo $schema;
        }
        ?>
    </head>

    <body class="<?= $bodyClass ?? '' ?>">
        <?= $this->section('content') ?>

        <footer class="footer">
            <?= $this->section('extra-footer') ?>
            <?php $this->insert('partials/footer'); ?>
        </footer>

        <?php 
        $url = (new MatomoTracker\Url('https://analytics.historia-arte.com/img.php', 1))
            ->url($page->getUrl())
            ->referrer($_SERVER['HTTP_REFERER'] ?? null)
            ->title($page->getTitle())
            ->rand();
        ?>

        <img src="<?= $url ?>" style="border:0;" alt="Al cargar esta imagen nos permites saber que nos has visitado. ¡Gracias!" class="matomo">
    </body>
</html>