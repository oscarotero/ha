<?php


use Phinx\Migration\AbstractMigration;

class Specials extends AbstractMigration
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
        $this->table('special')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('startsAt', 'date', ['null' => true])
            ->addColumn('endsAt', 'date', ['null' => true])
            ->addIndex(['slug'], ['unique' => true])
            ->create();

        $this->table('artwork_special')
            ->addColumn('artwork_id', 'integer', ['null' => false])
            ->addColumn('special_id', 'integer', ['null' => false])
            ->addIndex(['artwork_id', 'special_id'], ['unique' => true])
            ->addForeignKey('artwork_id', 'artwork', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('special_id', 'artist', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('reportage_special')
            ->addColumn('reportage_id', 'integer', ['null' => false])
            ->addColumn('special_id', 'integer', ['null' => false])
            ->addIndex(['reportage_id', 'special_id'], ['unique' => true])
            ->addForeignKey('reportage_id', 'reportage', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('special_id', 'artist', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();
    }
}
