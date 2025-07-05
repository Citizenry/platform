<?php

use Phinx\Migration\AbstractMigration;

class UpdateOauthClientSecretFromEnv extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            UPDATE oauth_clients
            SET secret = '" . getenv('OAUTH_CLIENT_SECRET') . "'
            WHERE id = 'streetsignal-ios'
        ");
    }

    public function down()
    {
        // It is not recommended to revert this change as it depends on an environment variable.
        // If needed, the previous value can be restored manually.
    }
}
