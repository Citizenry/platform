<?php

/**
 * StreetSignal Acl Trait
 *
 * Gives objects a method for storing an ACL instance.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

use StreetSignal\Contracts\Acl as AclInterface;

trait Acl
{
    public $acl;

    public function setAcl(AclInterface $acl)
    {
        $this->acl = $acl;
    }
}
