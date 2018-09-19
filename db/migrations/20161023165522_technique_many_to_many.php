<?php

use Phinx\Migration\AbstractMigration;

class TechniqueManyToMany extends AbstractMigration
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
        $this->table('artwork_technique')
            ->addColumn('artwork_id', 'integer', ['null' => false])
            ->addColumn('technique_id', 'integer', ['null' => false])
            ->addIndex(['artwork_id', 'technique_id'], ['unique' => true])
            ->addForeignKey('artwork_id', 'artwork', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('technique_id', 'technique', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('artwork')
            ->addColumn('publishedAt', 'date', ['null' => true])
            ->update();
    }
}
