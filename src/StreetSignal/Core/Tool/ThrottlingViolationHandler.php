<?php

/**
 * StreetSignal throttling violation handler
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

use StreetSignal\Core\Exception\ThrottlingException;
use BehEh\Flaps\ViolationHandlerInterface;

class ThrottlingViolationHandler implements ViolationHandlerInterface
{
    public function handleViolation()
    {
        throw new ThrottlingException();
    }
}
