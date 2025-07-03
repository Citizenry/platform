<?php

/**
 * Create Message Usecase
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Message;

use StreetSignal\Core\Entity\Message;
use StreetSignal\Core\Usecase\CreateUsecase;

class CreateMessage extends CreateUsecase
{

    protected function getEntity()
    {
        $entity = parent::getEntity();

        // New messages cannot have any other state
        $entity->setState([
            'status' => Message::PENDING,
            'direction' => Message::OUTGOING
        ]);

        // Retrieve message type and data provider
        // from incoming message when replying to a message
        if (! empty($this->payload['parent_id'])) {
            $parent = $this->repo->get($this->payload['parent_id']);
            $entity->setState(['type' => $parent->type,
                               'data_source' => $parent->data_source]);
        }

        // If no user information is provided, default to the current session user.
        if (empty($entity->user_id) &&
            $this->auth->getUserId()
        ) {
            $entity->setState(['user_id' => $this->auth->getUserId()]);
        }

        return $entity;
    }
}
