<?php

/**
 * StreetSignal PostSet Listener
 *
 * Listens for new posts that are added to a set
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Listener;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use StreetSignal\Contracts\Repository\Entity\NotificationQueueRepository;

class PostSetListener extends AbstractListener
{
    protected $repo;

    public function setRepo(NotificationQueueRepository $repo)
    {
        $this->repo = $repo;
    }

    public function handle(EventInterface $event, $set_id = null, $post_id = null)
    {
        // Insert into Notification Queue
        $state = [
            'set'  => $set_id,
            'post' => $post_id
        ];

        $entity = $this->repo->getEntity();
        $entity->setState($state);
        $this->repo->create($entity);
    }
}
