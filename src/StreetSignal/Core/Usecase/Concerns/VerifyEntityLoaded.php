<?php

/**
 * StreetSignal Verify Entity Loaded Trait
 *
 * Gives objects one new method:
 * `verifyEntityLoaded(Entity $entity)`
 *
 * Triggers a NotFoundException if it's not.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Concerns;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Exception\NotFoundException;

trait VerifyEntityLoaded
{
    /**
     * Verifies that a given entity has been loaded, by checking that the "id"
     * property is not empty.
     * @param  \StreetSignal\Contracts\Entity $entity
     * @param  mixed $lookup
     * @return \StreetSignal\Contracts\Entity
     * @throws \StreetSignal\Core\Exception\NotFoundException
     */
    protected function verifyEntityLoaded(Entity $entity, $lookup)
    {
        if (!$entity->getId()) {
            if (is_array($lookup)) {
                $arr = [];
                foreach ($lookup as $key => $val) {
                    $arr[] = "$key: $val";
                }
                $lookup_string = implode(', ', $arr);
            } else {
                $lookup_string = $lookup;
            }

            throw new NotFoundException(sprintf(
                'Could not locate any %s matching [%s]',
                $entity->getResource(),
                $lookup_string
            ));
        }

        return $entity;
    }
}
