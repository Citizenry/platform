<?php

/**
 * Add post to Set Usecase
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Set;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Usecase\CreateUsecase;
use StreetSignal\Core\Usecase\Concerns\VerifyEntityLoaded;

class CreateSet extends CreateUsecase
{
    use AuthorizeSet, VerifyEntityLoaded;

    /**
     * Find entity based on identifying parameters.
     *
     * @return Entity
     */
    protected function getEntity()
    {
        $entity = parent::getEntity();
        // always use the current session user.
        if ($this->auth->getUserId()) {
            $entity->setState(['user_id' => $this->auth->getUserId()]);
        }

        return $entity;
    }
}
