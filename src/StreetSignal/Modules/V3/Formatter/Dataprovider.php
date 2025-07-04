<?php

/**
 * StreetSignal API Formatter for Data Provider
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class Dataprovider extends API
{
    use FormatterAuthorizerMetadata;

    protected function formatOptions(array $options)
    {
        foreach ($options as $name => $input) {
            if (isset($input['description']) and $input['description'] instanceof \Closure) {
                $options[$name]['description'] = $options[$name]['description']();
            }

            if (isset($input['label']) and $input['label'] instanceof \Closure) {
                $options[$name]['label'] = $options[$name]['label']();
            }

            if (isset($input['rules']) and $input['rules'] instanceof \Closure) {
                $options[$name]['rules'] = $options[$name]['rules']();
            }
        }
        return $options;
    }
}
