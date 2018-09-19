<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CustomImageCrop extends AbstractMigration
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
        $this->table('artwork')
            ->addColumn('imageCropX', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('imageCropY', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->update();

        $this->table('artist')
            ->addColumn('imageCropX', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('imageCropY', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->update();

        $this->table('reportage')
            ->addColumn('imageCropX', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('imageCropY', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->update();

        $this->table('movement')
            ->addColumn('imageCropX', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('imageCropY', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->update();

        $this->table('technique')
            ->addColumn('imageCropX', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->addColumn('imageCropY', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_TINY])
            ->update();
    }
}
