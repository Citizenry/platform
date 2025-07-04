<?php

/**
 * StreetSignal Platform File Reader Tool
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface FileReader
{
    /**
     * Read a file and return a Traversable object
     *
     * @param  \SplFileObject|string $file
     * @return \Traversable
     */
    public function process($file);

    public function setOffset($offset);

    public function setLimit($limit);
}
