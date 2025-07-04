<?php
/**
 * *
 *  * StreetSignal Acl
 *  *
 *  * @author     StreetSignal Team <team@streetsignal.com>
 *  * @package    StreetSignal\Application
 *  * @copyright  2020 Ushahidi
 *  * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 *
 *
 */

namespace StreetSignal\Modules\V5\Listeners;

use StreetSignal\Modules\V5\Events\PostUpdatedEvent;

class PostUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostUpdatedEvent  $event
     * @return void
     */
    public function handle(PostUpdatedEvent $event)
    {
        $state = [
            'post_id' => $event->post->id,
            'event_type' => 'update'
        ];
        $webhookRepo = service('repository.webhook.job');
        $entity = $webhookRepo->getEntity();
        $entity->setState($state);
        $webhookRepo->create($entity);
    }
}
