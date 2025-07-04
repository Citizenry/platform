<?php

/**
 * Repository for Form Roles
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts\Repository\Entity;

use StreetSignal\Contracts\EntityGet;
use StreetSignal\Contracts\EntityExists;

interface FormRoleRepository extends
    EntityGet,
    EntityExists
{

    /**
     * @param  int $form_id
     * @return \StreetSignal\Contracts\Entity[]
     */
    public function getByForm(int $form_id);

    /**
     * @param  int $role_id
     * @param  int $form_id
     * @return boolean
     */
    public function existsInFormRole(int $role_id, int $form_id);

    /**
     * @param  \StreetSignal\Contracts\Entity[]  $entities
     * @return \StreetSignal\Contracts\Entity[]
     */
    public function updateCollection(array $entities);
}
