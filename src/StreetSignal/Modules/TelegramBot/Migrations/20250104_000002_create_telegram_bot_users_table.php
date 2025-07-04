<?php

use Phinx\Migration\AbstractMigration;

class CreateTelegramBotUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('telegram_bot_users');
        
        $table->addColumn('telegram_user_id', 'biginteger')
              ->addColumn('telegram_username', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('telegram_first_name', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('telegram_last_name', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('telegram_language_code', 'string', ['limit' => 10, 'null' => true])
              ->addColumn('user_id', 'integer', ['null' => true])
              ->addColumn('oauth_token', 'text', ['null' => true])
              ->addColumn('oauth_refresh_token', 'text', ['null' => true])
              ->addColumn('oauth_expires_at', 'timestamp', ['null' => true])
              ->addColumn('is_blocked', 'boolean', ['default' => false])
              ->addColumn('last_interaction_at', 'timestamp', ['null' => true])
              ->addColumn('total_reports_submitted', 'integer', ['default' => 0])
              ->addColumn('preferences', 'json', ['null' => true])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addIndex(['telegram_user_id'], ['unique' => true])
              ->addIndex(['user_id'])
              ->addIndex(['telegram_username'])
              ->addIndex(['is_blocked'])
              ->addIndex(['last_interaction_at'])
              ->create();
    }
}