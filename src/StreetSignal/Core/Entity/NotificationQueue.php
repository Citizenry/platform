<?php

/**
 * StreetSignal Notification Queue
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\StaticEntity;

class NotificationQueue extends StaticEntity
{
    protected $id;
    protected $post_id;
    protected $set_id;
    protected $created;

    // StatefulData
    protected function getDerived()
    {
        // Foreign key alias
        return [
            'post_id' => ['post', 'post.id'],
            'set_id'  => ['set', 'set.id']
        ];
    }


    // DataTransformer
    protected function getDefinition()
    {
        return [
            'id'       => 'int',
            'post'     => false,
            'post_id'  => 'int',
            'set'      => false,
            'set_id'   => 'string',
            'created'  => 'int'
        ];
    }

    // Entity
    public function getResource()
    {
        return 'notification_queue';
    }
}
