<?php

use Phinx\Migration\AbstractMigration;

class AddAvatarPathToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('avatar_path', 'string', [
            'limit' => 255,
            'null' => true,
            'comment' => 'Path to user uploaded avatar image'
        ])
        ->update();
    }
}