<?php

namespace StreetSignal\Modules\V2\Contracts;

use StreetSignal\Modules\V2\Import;

interface Mapper
{
    /**
     * Map source array to Entity
     *
     * @param  Import $import   Import to scope any relation mappings
     * @param  array  $input    Source data
     * @return \StreetSignal\Contracts\Entity|array|null null if the mapping is not possible
     */
    public function __invoke(Import $import, array $input) : ?array;
}
