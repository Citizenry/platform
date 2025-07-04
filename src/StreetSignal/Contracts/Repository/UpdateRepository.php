<?php

/**
 * StreetSignal Platform Update Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityGet;

interface UpdateRepository extends EntityGet
{
    /**
     * @param array|Entity $entity
     *
     * @return void
     */
    public function update(Entity $entity);

    /**
     * @param array|Entity[] $entities
     *
     * @return void
     */
    // public function updateCollection(array $entities);
}
