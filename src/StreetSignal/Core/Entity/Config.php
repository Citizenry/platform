<?php

/**
 * StreetSignal Config Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Entity;

use StreetSignal\Core\DynamicEntity;

class Config extends DynamicEntity
{
    // DataTransformer
    protected function getDefinition()
    {
        return ['id' => 'string'];
    }

    // Entity
    public function getResource()
    {
        return 'config';
    }

    // StatefulData
    public function getImmutable()
    {
        return array_merge(parent::getImmutable(), ['allowed_privileges']);
    }
}
