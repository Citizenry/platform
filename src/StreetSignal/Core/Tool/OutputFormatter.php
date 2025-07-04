<?php

/**
 * StreetSignal Platform Output Formatter
 *
 * Meant to be used in combination with Formatter interface!
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Tool;

interface OutputFormatter
{
    /**
     * Get the MIME type of a format.
     * @return  string
     */
    public function getMimeType();
}
