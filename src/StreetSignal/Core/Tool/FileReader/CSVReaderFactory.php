<?php

/**
 * StreetSignal Reader Factory
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Application
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool\FileReader;

use StreetSignal\Core\Tool\Reader;
use StreetSignal\Contracts\ReaderFactory;

class CSVReaderFactory implements ReaderFactory
{
    public function createReader($file)
    {
        return $file instanceof \SplFileObject
            ? Reader::createFromFileObject($file)
            : Reader::createFromPath($file);
    }
}
