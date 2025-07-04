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

namespace StreetSignal\Modules\V5\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'StreetSignal\Modules\V5\Events\PostCreatedEvent' => [
            'StreetSignal\Modules\V5\Listeners\PostCreatedListener',
        ],
        'StreetSignal\Modules\V5\Events\PostUpdatedEvent' => [
            'StreetSignal\Modules\V5\Listeners\PostUpdatedListener',
        ],
    ];
}
