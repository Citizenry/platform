<?php

/**
 * StreetSignal Platform Formatter Interface
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Contracts;

interface Formatter
{
    /**
     * @param  \StreetSignal\Contracts\Entity|\StreetSignal\Contracts\Entity[]|mixed $data
     *
     * @return mixed
     *
     * @throws \StreetSignal\Core\Exception\FormatterException
     */
    public function __invoke($data);
}
