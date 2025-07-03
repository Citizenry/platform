<?php

/**
 * StreetSignal Reader
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

use League\Csv\Reader as CSVReader;
use StreetSignal\Contracts\Reader as ReaderInterface;

class Reader extends CSVReader implements ReaderInterface
{
    // intentionally left blank
}
