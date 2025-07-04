<?php

/**
 * StreetSignal API Formatter for HXL License
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 Ushahidi
 * @license   https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\HXL;

use StreetSignal\Modules\V3\Formatter\API;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class HXLSend extends API
{
    use FormatterAuthorizerMetadata;

    /**
     * @param $job
     * @return array|mixed|\StreetSignal\Modules\V3\Formatter\Array
     */
    public function __invoke($job)
    {
        // TODO graceful error reporting to the client
        return $job->asArray();
    }
}
