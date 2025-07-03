<?php

/**
 * StreetSignal Platform Entity Create Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Tos;

use StreetSignal\Core\Usecase\CreateUsecase;

class CreateTos extends CreateUsecase
{

    protected function getEntity()
    {
        $entity = parent::getEntity();

        // Default to the current session user.
        $entity->setState(['user_id' => $this->auth->getUserId()]);

        return $entity;
    }
}
