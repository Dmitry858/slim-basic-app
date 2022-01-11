<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMenuTableMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('menu');

        $table->addColumn('title', 'string', ['limit' => 128])
              ->addColumn('link', 'string', ['limit' => 128])
              ->addColumn('parent_id', 'integer', ['null' => true])
              ->addTimestamps()
              ->create();
    }
}
