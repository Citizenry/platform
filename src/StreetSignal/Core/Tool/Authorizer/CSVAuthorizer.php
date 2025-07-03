<?php

/**
 * StreetSignal CSV Authorizer
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Authorizer;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Entity\CSV;
use StreetSignal\Contracts\Permission;
use StreetSignal\Contracts\Authorizer;
use StreetSignal\Core\Concerns\AdminAccess;
use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Core\Concerns\PrivAccess;
use StreetSignal\Core\Concerns\Acl as AccessControlList;
use StreetSignal\Core\Facade\Feature;

class CSVAuthorizer implements Authorizer
{
    use UserContext;

    // It uses `PrivAccess` to provide the `getAllowedPrivs` method.
    use PrivAccess;

    // Check if user has Admin access
    use AdminAccess;

    // Check that the user has the necessary permissions
    // if roles are available for this deployment.
    use AccessControlList;

    /* Authorizer */
    public function isAllowed(Entity $entity, $privilege)
    {
        // Check if the user can import data first
        if (!Feature::isEnabled('data-import')) {
            return false;
        }

        // These checks are run within the user context.
        $user = $this->getUser();

        // Allow role with the right permissions
        if ($this->acl->hasPermission($user, Permission::DATA_IMPORT_EXPORT) or
            $this->acl->hasPermission($user, Permission::LEGACY_DATA_IMPORT)) {
            return true;
        }

        // Allow admin access
        if ($this->isUserAdmin($user)) {
            return true;
        }

        return false;
    }
}
