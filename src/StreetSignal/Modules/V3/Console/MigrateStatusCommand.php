<?php

namespace StreetSignal\Modules\V3\Console;

use Illuminate\Console\Command;
use Phinx\Console\Command\Status as PhinxStatusCommand;

class MigrateStatusCommand extends PhinxStatusCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('phinx:migrate:status');
    }
}
