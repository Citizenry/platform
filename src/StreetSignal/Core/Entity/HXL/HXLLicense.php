<?php

/**
 * StreetSignal HXLLicense Entity
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Platform
 * @copyright 2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity\HXL;

use StreetSignal\Core\StaticEntity;

class HXLLicense extends StaticEntity
{
    protected $id;
    protected $code;
    protected $name;
    protected $link;

    // DataTransformer
    public function getDefinition()
    {
        return [
            'id'        => 'int',
            'code'      => 'string',
            'name'      => 'string',
            'link'      => 'string',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'hxl_license';
    }
}
