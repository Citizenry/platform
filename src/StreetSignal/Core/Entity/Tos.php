<?php

/**
 * StreetSignal Tag
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class Tos extends StaticEntity
{
    protected $id;
    protected $user_id;
    protected $agreement_date;
    protected $tos_version_date;

    protected function getDerived()
    {
        // Foreign key alias
        return [
            'user_id' => ['user', 'user.id']
        ];
    }

    protected function getDefinition()
    {
        return [
            'id'              => 'int',
            'user_id'         => 'int',
            'agreement_date'  => '*date',
            'tos_version_date' => '*date',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'tos';
    }
}
