<?php

namespace App;

class Admin extends \Folk\Admin
{
    public $title = 'Historia Arte';
    public $description = 'Gestor de contenidos';

    public function __construct($uri, App $app)
    {
        putenv('APP_ADMIN=true');
        parent::__construct($app->getPath(), $uri);

        $this->set('url', $app->getUri());
        $this->set('app', $app);

        $this->setEntities([
            Admin\Artwork::class,
            Admin\Reportage::class,
            Admin\Artist::class,
            Admin\Ephemeris::class,
            Admin\Special::class,
            Admin\City::class,
            Admin\Country::class,
            Admin\Movement::class,
            Admin\MovementGroup::class,
            Admin\Tag::class,
            Admin\Technique::class,
            Admin\Museum::class,
            Admin\Author::class,
            Admin\Text::class,
            Admin\Redirect::class,
        ]);

        $this->addEntity(new Admin\Config('config', $this), 'config');
    }
}
