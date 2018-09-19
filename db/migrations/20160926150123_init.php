<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Init extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('country')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addIndex(['slug'], ['unique' => true])
            ->create();

        $this->table('movementGroup')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addIndex(['slug'], ['unique' => true])
            ->create();

        $this->table('movement')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('imageFile', 'string', ['null' => true])
            ->addColumn('movementGroup_id', 'integer', ['null' => false])
            ->addIndex(['slug'], ['unique' => true])
            ->addForeignKey('movementGroup_id', 'movementGroup', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->create();

        $this->table('technique')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('imageFile', 'string', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->create();

        $this->table('tag')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addIndex(['slug'], ['unique' => true])
            ->create();

        $this->table('artist')
            ->addColumn('name', 'string')
            ->addColumn('surname', 'string', ['null' => true])
            ->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('slug', 'string')
            ->addColumn('imageFile', 'string', ['null' => true])
            ->addColumn('yearBorn', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_SMALL])
            ->addColumn('yearDead', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_SMALL])
            ->addColumn('bio', 'text', ['null' => true])
            ->addColumn('country_id', 'integer', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->addForeignKey('country_id', 'country', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->create();

        $this->table('artwork')
            ->addColumn('title', 'string')
            ->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('isActivated', 'boolean')
            ->addColumn('slug', 'string')
            ->addColumn('subtitle', 'string', ['null' => true])
            ->addColumn('imageFile', 'string', ['null' => true])
            ->addColumn('copyright', 'string', ['null' => true])
            ->addColumn('year', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_SMALL])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('body', 'text')
            ->addColumn('technique_id', 'integer', ['null' => true])
            ->addColumn('country_id', 'integer', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->addForeignKey('technique_id', 'technique', 'id', ['delete' => 'SET NULL', 'update' => 'RESTRICT'])
            ->addForeignKey('country_id', 'country', 'id', ['delete' => 'SET NULL', 'update' => 'RESTRICT'])
            ->create();

        $this->table('artist_artwork')
            ->addColumn('artwork_id', 'integer', ['null' => false])
            ->addColumn('artist_id', 'integer', ['null' => false])
            ->addIndex(['artwork_id', 'artist_id'], ['unique' => true])
            ->addForeignKey('artwork_id', 'artwork', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('artist_id', 'artist', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('artwork_tag')
            ->addColumn('artwork_id', 'integer', ['null' => false])
            ->addColumn('tag_id', 'integer', ['null' => false])
            ->addIndex(['artwork_id', 'tag_id'], ['unique' => true])
            ->addForeignKey('artwork_id', 'artwork', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('tag_id', 'tag', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('artwork_movement')
            ->addColumn('artwork_id', 'integer', ['null' => false])
            ->addColumn('movement_id', 'integer', ['null' => false])
            ->addIndex(['artwork_id', 'movement_id'], ['unique' => true])
            ->addForeignKey('artwork_id', 'artwork', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('movement_id', 'movement', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('redirect')
            ->addColumn('from', 'string', ['null' => false])
            ->addColumn('to', 'string', ['null' => false])
            ->addIndex(['from'], ['unique' => true])
            ->create();
    }
}
