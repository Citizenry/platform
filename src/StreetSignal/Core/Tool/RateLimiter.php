<?php

/**
 * StreetSignal Rate Limiter
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

use StreetSignal\Contracts\RateLimiter as RateLimiterInterface;
use StreetSignal\Contracts\Entity;
use BehEh\Flaps\Flap;
use BehEh\Flaps\ThrottlingStrategyInterface;

class RateLimiter implements RateLimiterInterface
{
    /**
     * @var \BehEh\Flaps\Flap
     */
    protected $flap;

    /**
     * Sets up a rate limiter with a throttling strategy
     * @param \BehEh\Flaps\Flap $flap
     * @param \BehEh\Flaps\ThrottlingStrategyInterface $trottlingStrategy
     */
    public function __construct(Flap $flap, ThrottlingStrategyInterface $throttlingStrategy)
    {
        $this->flap = $flap;

        // @todo allow multiple strategies
        $this->flap->pushThrottlingStrategy($throttlingStrategy);
    }

    public function limit(Entity $entity)
    {
        $this->flap->limit($entity->id);
    }
}
