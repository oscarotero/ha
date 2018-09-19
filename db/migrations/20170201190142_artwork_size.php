<?php

use Phinx\Migration\AbstractMigration;

class ArtworkSize extends AbstractMigration
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
        $this->table('artwork')
            ->addColumn('imageWidth', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('imageHeight', 'integer', ['null' => true, 'signed' => false])
            ->removeColumn('layout')
            ->update();

        $rows = $this->fetchAll('SELECT id, imageFile FROM artwork');

        foreach ($rows as $row) {
            $file = __DIR__.'/../../data/uploads/artwork/imageFile/'.$row['imageFile'];
            $size = getimagesize($file);
            $this->execute(sprintf('UPDATE artwork SET imageWidth = "%d", imageHeight = "%d" WHERE id = "%s" LIMIT 1', $size[0], $size[1], $row['id']));
        }
    }

    public function down()
    {
        $this->table('artwork')
            ->removeColumn('imageWidth')
            ->removeColumn('imageHeight')
            ->addColumn('layout', 'enum', ['values' => 'vertical,horizontal'])
            ->update();
    }
}
