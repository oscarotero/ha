<?php

use Phinx\Migration\AbstractMigration;

class ArtistMultimedia extends AbstractMigration
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
        $this->table('artist')
            ->addColumn('body', 'text')
            ->update();

        $rows = $this->fetchAll('SELECT * FROM artist');
        $stmt = $this->getAdapter()->getConnection()->prepare('UPDATE artist SET body = ? WHERE id = ? LIMIT 1');

        foreach ($rows as $row) {
            $body = serialize([
                [
                    'type' => 'text',
                    'text' => $row['bio'],
                ]
            ]);

            $stmt->execute([$body, $row['id']]);
        }

        $this->table('artist')
            ->removeColumn('bio')
            ->update();
    }
}
