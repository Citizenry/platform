<?php

namespace StreetSignal\Modules\V3\Console;

use Illuminate\Console\Command;
use Phinx\Console\Command\Rollback as PhinxRollbackCommand;

class MigrateRollbackCommand extends PhinxRollbackCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('phinx:migrate:rollback');
    }
}
