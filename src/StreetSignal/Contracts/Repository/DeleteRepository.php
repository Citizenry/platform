<?php

/**
 * StreetSignal Platform Delete Repository
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\EntityGet;

interface DeleteRepository extends EntityGet
{

    /**
     * @param  \StreetSignal\Contracts\Entity $entity
     *
     * @return integer|void
     */
    public function delete(Entity $entity);
}
