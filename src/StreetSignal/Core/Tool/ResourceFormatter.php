<?php

/**
 * StreetSignal Reader
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

use StreetSignal\Contracts\Formatter;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class ResourceFormatter extends Resource implements Formatter
{
    public function __invoke($data)
    {
        return new self($data);
    }
}
