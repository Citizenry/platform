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
use StreetSignal\Contracts\Repository\Entity\WebhookRepository;
use StreetSignal\Contracts\Repository\Entity\WebhookJobRepository;

class PostListener extends AbstractListener
{
    protected $repo;

    protected $webhook_repo;

    public function setRepo(WebhookJobRepository $repo)
    {
        $this->repo = $repo;
    }

    public function setWebhookRepo(WebhookRepository $webhook_repo)
    {
        $this->webhook_repo = $webhook_repo;
    }

    public function handle(EventInterface $event, $post_id = null, $event_type = null)
    {
        $state = [
            'post_id' => $post_id,
            'event_type' => $event_type
        ];

        $entity = $this->repo->getEntity();
        $entity->setState($state);
        $this->repo->create($entity);
    }
}
