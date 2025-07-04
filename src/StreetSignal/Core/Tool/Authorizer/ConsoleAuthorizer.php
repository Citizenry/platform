<?php

/**
 * StreetSignal Console Authorizer
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Authorizer;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Authorizer;
use StreetSignal\Core\Concerns\PrivAccess;
use StreetSignal\Core\Concerns\UserContext;

// The `ConsoleAuthorizer` class is responsible for access checks for console tasks
class ConsoleAuthorizer implements Authorizer
{
    // The access checks are run under the context of a specific user
    // @todo refactor to avoid including this. CLI doesn't have a user context
    use UserContext;

    // It uses `PrivAccess` to provide the `getAllowedPrivs` method.
    use PrivAccess;

    /* Authorizer */
    public function isAllowed(Entity $entity, $privilege)
    {
        // All console requests are authorized
        return true;
    }
}
