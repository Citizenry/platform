<?php

/**
 * StreetSignal Platform Export Job Create Use Case
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Platform
 * @copyright 2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Export\Job;

use StreetSignal\Core\Usecase\ReadUsecase;
use StreetSignal\Core\Concerns\UserContext;

class PostCount extends ReadUsecase
{
    use UserContext;

    public function interact()
    {
        $entity = $this->getEntity();
        $this->getSession()->setUser($entity->user_id);
        return $this->repo->getPostCount($entity->id);
    }
}
