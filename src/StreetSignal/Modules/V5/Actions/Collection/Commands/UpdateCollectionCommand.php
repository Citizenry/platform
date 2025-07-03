<?php

namespace StreetSignal\Modules\V5\Actions\Collection\Commands;

use App\Bus\Command\Command;
use StreetSignal\Core\Entity\Set as Collection;

class UpdateCollectionCommand implements Command
{
    /**
     * @var Collection
     */
    private $entity;

    /**
     * @var int
     */
    private $id;


    public function __construct(int $id, Collection $entity)
    {
        $this->entity = $entity;
        $this->id = $id;
    }


    /**
     * @return Collection
     */
    public function getEntity(): Collection
    {
        return $this->entity;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
