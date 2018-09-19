<?php

use Phinx\Migration\AbstractMigration;

class ArtistRelations extends AbstractMigration
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
        $this->table('artist_tag')
            ->addColumn('artist_id', 'integer', ['null' => false])
            ->addColumn('tag_id', 'integer', ['null' => false])
            ->addIndex(['artist_id', 'tag_id'], ['unique' => true])
            ->addForeignKey('artist_id', 'artist', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('tag_id', 'tag', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('artist_movement')
            ->addColumn('artist_id', 'integer', ['null' => false])
            ->addColumn('movement_id', 'integer', ['null' => false])
            ->addIndex(['artist_id', 'movement_id'], ['unique' => true])
            ->addForeignKey('artist_id', 'artist', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('movement_id', 'movement', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();
    }
}
