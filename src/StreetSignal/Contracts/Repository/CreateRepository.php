<?php

/**
 * StreetSignal Platform Create Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityGet;

interface CreateRepository extends EntityGet
{
    /**
     * Creates a new record and returns the created id.
     * @param  array|\StreetSignal\Contracts\Entity $entity
     * @return mixed
     */
    public function create(Entity $entity);
}
