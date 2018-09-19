<?php


use Phinx\Migration\AbstractMigration;

class City extends AbstractMigration
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
        $this->table('city')
            ->addColumn('name', 'string')
            ->addColumn('country_id', 'integer')
            ->addForeignKey('country_id', 'country', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->table('museum')
            ->addColumn('address', 'string')
            ->addColumn('city_id', 'integer', ['null' => true])
            ->addForeignKey('city_id', 'city', 'id', ['delete' => 'SET NULL', 'update' => 'RESTRICT'])
            ->update();
    }
}
