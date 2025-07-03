<?php

/**
 * StreetSignal CountryCode Authorizer
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Authorizer;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Permission;
use StreetSignal\Contracts\Authorizer;
use StreetSignal\Core\Concerns\AdminAccess;
use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Core\Concerns\PrivAccess;
use StreetSignal\Core\Concerns\Acl as AccessControlList;

class CountryCodeAuthorizer implements Authorizer
{
    // The access checks are run under the context of a specific user
    use UserContext;

    // It uses `AdminAccess` to check if the user has admin access
    use AdminAccess;

    // It uses `PrivAccess` to provide the `getAllowedPrivs` method.
    use PrivAccess;

    // Check that the user has the necessary permissions
    // if roles are available for this deployment.
    use AccessControlList;

    /* Authorizer */
    public function isAllowed(Entity $entity, $privilege)
    {
        // These checks are run within the `User` context.
        $user = $this->getUser();

        // Only read and search-usecases can be performed on country-codes
        if ($privilege === 'read' || $privilege === 'search') {
            // Allow role with the right permissions to do everything else
            if ($this->acl->hasPermission($user, Permission::MANAGE_SETTINGS)) {
                return true;
            }

            // If a user has the 'admin' role, they can do pretty much everything else
            if ($this->isUserAdmin($user)) {
                return true;
            }
        }

        // If no other access checks succeed, we default to denying access
        return false;
    }
}
