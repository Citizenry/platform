<?php

/**
 * StreetSignal Platform Update Message Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Message;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Usecase\UpdateUsecase;

class UpdateMessage extends UpdateUsecase
{
    protected function verifyValid(Entity $entity)
    {
        // $this->validator->set([
        //     'direction' => $entity->direction,
        //     'status'    => $entity->status,
        // ]);
        parent::verifyValid($entity);
    }
}
