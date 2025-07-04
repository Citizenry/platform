<?php

use Phinx\Migration\AbstractMigration;

class CreateTelegramConversationsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('telegram_conversations');
        
        $table->addColumn('telegram_bot_user_id', 'integer')
              ->addColumn('chat_id', 'biginteger')
              ->addColumn('current_state', 'string', ['limit' => 100])
              ->addColumn('state_data', 'json', ['null' => true])
              ->addColumn('last_message_id', 'integer', ['null' => true])
              ->addColumn('expires_at', 'timestamp')
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addIndex(['telegram_bot_user_id'])
              ->addIndex(['chat_id'])
              ->addIndex(['current_state'])
              ->addIndex(['expires_at'])
              ->addForeignKey('telegram_bot_user_id', 'telegram_bot_users', 'id', ['delete' => 'CASCADE'])
              ->create();
    }
}