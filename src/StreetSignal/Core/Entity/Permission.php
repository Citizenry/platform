<?php

/**
 * StreetSignal Permission Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class Permission extends StaticEntity
{
    protected $id;
    protected $name;
    protected $description;

    // DataTransformer
    public function getDefinition()
    {
        return [
            'id' => 'int',
            'name' => 'string',
            'description' => 'string',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'permission';
    }

    // StatefulData
    protected function getImmutable()
    {
        return array_merge(parent::getImmutable(), ['name']);
    }
}
