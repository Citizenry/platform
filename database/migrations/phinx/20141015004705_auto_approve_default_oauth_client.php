<?php

use Phinx\Migration\AbstractMigration;

class AutoApproveDefaultOauthClient extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute("UPDATE oauth_clients SET auto_approve = 1 WHERE id = 'streetsignalui'");
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute("UPDATE oauth_clients SET auto_approve = 0 WHERE id = 'streetsignalui'");
    }
}
