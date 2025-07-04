<?php

use Phinx\Migration\AbstractMigration;

class CreateTelegramBotConfigTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('telegram_bot_config');
        
        $table->addColumn('bot_token', 'string', ['limit' => 255])
              ->addColumn('webhook_url', 'string', ['limit' => 500, 'null' => true])
              ->addColumn('webhook_secret', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('default_survey_id', 'integer', ['null' => true])
              ->addColumn('welcome_message', 'text', ['null' => true])
              ->addColumn('help_message', 'text', ['null' => true])
              ->addColumn('anonymous_submissions_enabled', 'boolean', ['default' => true])
              ->addColumn('max_file_size_mb', 'integer', ['default' => 10])
              ->addColumn('allowed_file_types', 'json', ['null' => true])
              ->addColumn('rate_limit_per_minute', 'integer', ['default' => 10])
              ->addColumn('session_timeout_minutes', 'integer', ['default' => 30])
              ->addColumn('is_active', 'boolean', ['default' => false])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addIndex(['default_survey_id'])
              ->addIndex(['is_active'])
              ->create();
    }
}