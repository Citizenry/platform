<?php

/**
 * StreetSignal API Formatter for Export Jobs
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2018 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Modules\V3\Formatter;

use StreetSignal\Core\Concerns\FormatterAuthorizerMetadata;
use StreetSignal\Core\Concerns\FormatRackspaceURL;

class ExportJob extends API
{
    use FormatterAuthorizerMetadata;
    use FormatRackspaceURL;
}
