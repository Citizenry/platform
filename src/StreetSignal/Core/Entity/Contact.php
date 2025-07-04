<?php

/**
 * StreetSignal Contact Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class Contact extends StaticEntity
{
    protected $id;
    protected $user_id;
    protected $data_source;
    protected $type;
    protected $contact;
    protected $created;
    protected $updated;
    protected $can_notify;
    public $country_code; // we only want this for validation, needs to be unset before saving
    // StatefulData
    protected function getDerived()
    {
        // Foreign key alias
        return [
            'user_id' => ['user', 'user.id']
        ];
    }

    // DataTransformer
    protected function getDefinition()
    {
        return [
            'id'            => 'int',
            'user'          => false, /* alias */
            'user_id'       => 'int',
            'data_source'   => 'string',
            'type'          => 'string',
            'contact'       => 'string',
            'created'       => 'int',
            'updated'       => 'int',
            'can_notify'    => 'bool',
        ];
    }

    // Entity
    public function getResource()
    {
        return 'contacts';
    }

    protected function getDefaultData()
    {
        return [
            'can_notify' => 0,
        ];
    }
}
