<?php

/**
 * StreetSignal Export Job Authorizer
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Authorizer;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Authorizer;
use StreetSignal\Core\Concerns\AdminAccess;
use StreetSignal\Core\Concerns\OwnerAccess;
use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Contracts\Permission;
use StreetSignal\Core\Concerns\PrivAccess;
use StreetSignal\Core\Concerns\PrivateDeployment;
use StreetSignal\Core\Concerns\Acl as AccessControlList;

class ExportJobAuthorizer implements Authorizer
{
    // The access checks are run under the context of a specific user
    use UserContext;

    // To check whether the user has admin access
    use AdminAccess;

    // To check whether user owns the webhook
    use OwnerAccess;

    // It uses `PrivAccess` to provide the `getAllowedPrivs` method.
    use PrivAccess;

    // It uses `PrivateDeployment` to check whether a deployment is private
    use PrivateDeployment;

    // Check that the user has the necessary permissions
    // if roles are available for this deployment.
    use AccessControlList;


    /* Authorizer */
    public function isAllowed(Entity $entity, $privilege)
    {

        // These checks are run within the user context.
        $user = $this->getUser();

        // Only logged in users have access if the deployment is private
        if (!$this->canAccessDeployment($user)) {
            return false;
        }

        // First check whether there is a role with the right permissions
        if ($this->acl->hasPermission($user, Permission::DATA_IMPORT_EXPORT) or
            $this->acl->hasPermission($user, Permission::LEGACY_DATA_IMPORT)) {
            return true;
        }

        // First check whether there is a role with the right permissions
        if ($this->acl->hasPermission($user, Permission::MANAGE_POSTS)) {
            return true;
        }

        // Admin is allowed access to everything
        if ($this->isUserAdmin($user)) {
            return true;
        }

        // If no other access checks succeed, we default to denying access
        return false;
    }
}
