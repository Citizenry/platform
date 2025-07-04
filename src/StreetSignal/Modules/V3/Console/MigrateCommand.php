<?php

namespace StreetSignal\Modules\V3\Console;

use Phinx\Console\Command\Migrate as PhinxMigrateCommand;
use Symfony\Component\Console\Input\InputOption;

class MigrateCommand extends PhinxMigrateCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('phinx:migrate');

        $this->addOption('force', 'f', InputOption::VALUE_NONE);
    }
}
