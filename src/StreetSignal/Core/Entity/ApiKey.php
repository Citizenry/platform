<?php

/**
 * StreetSignal ApiKey Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class ApiKey extends StaticEntity
{
    protected $id;
    protected $api_key;
    protected $created;
    protected $updated;


    // DataTransformer
    protected function getDefinition()
    {
        return [
            'id'                => 'int',
            'api_key'           => 'string',
            'created'           => 'int',
            'updated'           => 'int',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'apikey';
    }
}
