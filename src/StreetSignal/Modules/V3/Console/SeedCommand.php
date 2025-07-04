<?php

namespace StreetSignal\Modules\V3\Console;

use Phinx\Console\Command\SeedRun as PhinxSeedRunCommand;

class SeedCommand extends PhinxSeedRunCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        parent::configure();

        $this->setName('phinx:seed:run');
    }
}
