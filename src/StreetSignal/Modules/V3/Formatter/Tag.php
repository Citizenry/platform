<?php

/**
 * StreetSignal API Formatter for Tag
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Tag extends API
{
    use FormatterAuthorizerMetadata;

    protected function formatColor($value)
    {
        // enforce a leading hash on color, or null if unset
        $value = ltrim($value, '#');
        return $value ? '#' . $value : null;
    }

    protected function formatChildren($tags)
    {
        $output = [];

        if (is_array($tags)) {
            foreach ($tags as $tagid) {
                $output[] = $this->getRelation('tags', $tagid);
                //$output[] = intval($tagid);
            }
        }

        return $output;
    }
}
