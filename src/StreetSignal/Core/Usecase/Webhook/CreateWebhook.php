<?php

/**
 * StreetSignal Platform Entity Webhook Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Webhook;

use StreetSignal\Core\Usecase\CreateUsecase;

class CreateWebhook extends CreateUsecase
{
    protected function getEntity()
    {
        $entity = parent::getEntity();

        // Add user id if this is not provided
        // TODO: throw this away
        if (empty($entity->user_id) && $this->auth->getUserId()) {
            $entity->setState(['user_id' => $this->auth->getUserId()]);
        }

        return $entity;
    }
}
