<?php

/**
 * StreetSignal Data Provider Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\BasicEntity;
use StreetSignal\Core\StaticEntity;

class DataProvider extends BasicEntity
{
    protected $id;
    protected $name;
    protected $services;
    protected $options;
    protected $inbound_fields;

    // DataTransformer
    protected function getDefinition()
    {
        return [
            'id'       => 'string',
            'name'     => 'string',
            'services' => 'array',
            'options'  => 'array',
            'inbound_fields'  => 'array',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'dataprovider';
    }
}
