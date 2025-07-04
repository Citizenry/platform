<?php

/**
 * StreetSignal API Formatter for Notifications
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Notification extends API
{
    use FormatterAuthorizerMetadata;

    protected function getFieldName($field)
    {
        $remap = [
            'set_id'  => 'set'
            ];

        if (isset($remap[$field])) {
            return $remap[$field];
        }

        return parent::getFieldName($field);
    }

    protected function formatSetId($set_id)
    {
        return $this->getRelation('sets', $set_id);
    }
}
