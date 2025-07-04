<?php

/**
 * StreetSignal Rate Limiter interface
 *
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface RateLimiter
{
    /**
     * @param \StreetSignal\Contracts\Entity $entity
     * @throws \Exception
     */
    public function limit(Entity $entity);
}
