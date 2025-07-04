<?php

/**
 * StreetSignal HXLTag Entity
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Platform
 * @copyright 2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity\HXL;

use StreetSignal\Core\StaticEntity;

class HXLTag extends StaticEntity
{
    protected $id;
    protected $tag_name;
    protected $hxl_attributes;
    protected $form_attribute_types;
    // DataTransformer
    public function getDefinition()
    {
        return [
            'id'        => 'int',
            'tag_name'      => 'string',
            'description' => 'string',
            'hxl_attributes'    => 'array',
            'form_attribute_types' => 'array'
        ];
    }

    // Entity
    public function getResource()
    {
        return 'hxl_tag';
    }
}
