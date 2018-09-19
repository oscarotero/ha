<?php


use Phinx\Migration\AbstractMigration;

class Authors extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('author')
            ->addColumn('slug', 'string', ['null' => true])
            ->addColumn('title', 'string', ['null' => true])
            ->addColumn('bio', 'text', ['null' => true])
            ->addColumn('imageFile', 'string', ['null' => true])
            ->addColumn('links', 'text', ['null' => true])
            ->addColumn('country_id', 'integer', ['null' => true])
            ->addForeignKey('country_id', 'country', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->update();
    }
}
