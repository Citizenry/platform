<?php

/**
 * StreetSignal CountryCode Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class CountryCode extends StaticEntity
{
    protected $id;
    protected $country_name;
    protected $dial_code;
    protected $country_code;

    // DataTransformer
    public function getDefinition()
    {
        return [
            'id'           => 'int',
            'country_name' => 'string',
            'dial_code'    => 'string',
            'country_code' => 'string'
        ];
    }

    // Entity
    public function getResource()
    {
        return 'country_codes';
    }
}
