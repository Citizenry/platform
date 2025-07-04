<?php

/**
 * StreetSignal API Formatter for HXL License
 *
 * @author    StreetSignal Team <team@streetsignal.com>
 * @package   StreetSignal\Application
 * @copyright 2014 Ushahidi
 * @license   https=>//www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter\HXL;

use StreetSignal\Contracts\Formatter;
use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;

class HXLOrganisations implements Formatter
{
    use FormatterAuthorizerMetadata;

    /**
     * @param  mixed $input
     * @return mixed
     * @throws \StreetSignal\Core\Exception\FormatterException
     */
    public function __invoke($input)
    {
        return $input;
    }
}
