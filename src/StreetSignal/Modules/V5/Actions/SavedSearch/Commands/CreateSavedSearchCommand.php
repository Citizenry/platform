<?php

namespace StreetSignal\Modules\V5\Actions\SavedSearch\Commands;

use App\Bus\Command\Command;
use StreetSignal\Core\Entity\SavedSearch;

class CreateSavedSearchCommand implements Command
{
    /**
     * @var SavedSearch
     */
    private $entity;

    public function __construct(SavedSearch $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return SavedSearch
     */
    public function getEntity(): SavedSearch
    {
        return $this->entity;
    }
}
