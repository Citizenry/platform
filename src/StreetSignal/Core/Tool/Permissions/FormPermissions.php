<?php

/**
 * Form Permissions
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Permissions;

use StreetSignal\Contracts\Entity;
use StreetSignal\Contracts\Permission;
use StreetSignal\Core\Concerns\Acl as AccessControlList;
use StreetSignal\Core\Concerns\AdminAccess;

class FormPermissions
{
    use AccessControlList;
    use AdminAccess;

    /**
     * Does the user have permission to edit the form?
     *
     * @param  \StreetSignal\Contracts\Entity   $user
     * @param  int|string    $form_id
     * @return boolean
     */
    public function canUserEditForm(Entity $user, $form_id)
    {
        // @todo delegate to form authorizer
        return $this->acl->hasPermission($user, Permission::MANAGE_POSTS);
    }
}
