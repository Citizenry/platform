<?php

/**
 * StreetSignal HXLMetadataAuthorizer Authorizer
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Authorizer;

use StreetSignal\Contracts\Entity;
use StreetSignal\Core\Concerns\AdminAccess;
use StreetSignal\Core\Concerns\OwnerAccess;
use StreetSignal\Core\Concerns\UserContext;
use StreetSignal\Core\Concerns\PrivAccess;
use StreetSignal\Core\Concerns\Acl as AccessControlList;

// The `HXLMetadataAuthorizer` class is responsible for access checks on `HXLMetadata` Entity
class HXLMetadataAuthorizer extends HXLAuthorizer
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

    use OwnerAccess;


    /* Authorizer */
    public function isAllowed(Entity $entity, $privilege)
    {
        if (parent::isAllowed($entity, $privilege)) {
            $user = $this->getUser();
            return $this->isUserOwner($entity, $user);
        }
        // If no other access checks succeed, we default to denying access
        return false;
    }
}
