<?php

use Phinx\Migration\AbstractMigration;

class Reportages extends AbstractMigration
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
        $this->table('reportage')
            ->addColumn('title', 'string')
            ->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('publishedAt', 'datetime', ['null' => true])
            ->addColumn('isActivated', 'boolean')
            ->addColumn('slug', 'string')
            ->addColumn('subtitle', 'string', ['null' => true])
            ->addColumn('imageFile', 'string', ['null' => true])
            ->addColumn('body', 'text')
            ->addColumn('author_id', 'integer', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->addForeignKey('author_id', 'author', 'id', ['delete' => 'SET NULL', 'update' => 'RESTRICT'])
            ->create();

        $this->table('reportage_tag')
            ->addColumn('reportage_id', 'integer', ['null' => false])
            ->addColumn('tag_id', 'integer', ['null' => false])
            ->addIndex(['reportage_id', 'tag_id'], ['unique' => true])
            ->addForeignKey('reportage_id', 'reportage', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('tag_id', 'tag', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();
    }
}
