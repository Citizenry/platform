<?php

/**
 * InteractsWithPostPermissions
 *
 * Gives objects a method for storing a post permissions
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\Permissions;

trait InteractsWithFormPermissions
{
    protected $formPermissions;

    public function setFormPermissions(FormPermissions $formPermissions)
    {
        $this->formPermissions = $formPermissions;
    }
}
