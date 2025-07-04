<?php

use Phinx\Migration\AbstractMigration;

class AddPostRelations extends AbstractMigration
{
    /**
     * Add post_relation table
     */
    public function change()
    {
        $this->table('post_relation')
            ->addColumn('post_id', 'integer', ['signed' => false])
            ->addColumn('form_attribute_id', 'integer', ['signed' => false])
            ->addColumn('value', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('created', 'integer', ['default' => 0])
            ->addForeignKey('form_attribute_id', 'form_attributes', 'id', [
                'delete' => 'CASCADE',
            ])
            ->addForeignKey('post_id', 'posts', 'id', [
                'delete' => 'CASCADE',
            ])
            ->addForeignKey('value', 'posts', 'id', [
                'delete' => 'CASCADE',
            ])
            ->create();
    }
}
