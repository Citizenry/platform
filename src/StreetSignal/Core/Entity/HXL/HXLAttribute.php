<?php

/**
 * StreetSignal HXLAttribute Entity
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Platform
 * @copyright 2014 StreetSignal
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity\HXL;

use StreetSignal\Core\StaticEntity;

class HXLAttribute extends StaticEntity
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
            'attribute'      => 'string',
            'description' => 'string',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'hxl_attribute';
    }
}
