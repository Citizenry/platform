<?php

/**
 * StreetSignal API Formatter for Layer
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Layer extends API
{
    use FormatterAuthorizerMetadata;

    protected function getFieldName($field)
    {
        $remap = [
            'media_id' => 'media',
            ];

        if (isset($remap[$field])) {
            return $remap[$field];
        }

        return parent::getFieldName($field);
    }

    protected function formatMediaId($media_id)
    {
        return $this->getRelation('media', $media_id);
    }
}
