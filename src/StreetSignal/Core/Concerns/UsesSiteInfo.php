<?php

/**
 * UsesSiteInfo trait
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

use StreetSignal\Core\Facade\Site;

trait UsesSiteInfo
{
    public function getSite()
    {
        return Site::instance();
    }
}
