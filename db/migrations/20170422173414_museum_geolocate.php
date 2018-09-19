<?php

use Phinx\Migration\AbstractMigration;

class MuseumGeolocate extends AbstractMigration
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
    public function up()
    {
        $this->table('museum')
            ->addColumn('country_id', 'integer', ['null' => true])
            ->addColumn('location', 'point', ['null' => true])
            ->addColumn('slug', 'string', ['null' => true])
            ->addColumn('city', 'string', ['null' => true])
            ->addForeignKey('country_id', 'country', 'id', ['delete' => 'SET NULL', 'update' => 'RESTRICT'])
            ->update();

        $this->execute('UPDATE museum SET slug = id');

        $this->table('museum')
            ->changeColumn('slug', 'string', ['null' => false])
            ->addIndex('slug', ['unique' => true])
            ->update();
    }

    public function down()
    {
        $this->table('museum')
            ->removeColumn('country_id')
            ->removeColumn('location')
            ->removeColumn('slug')
            ->removeColumn('city')
            ->dropForeignKey('country_id')
            ->update();
    }
}
