<?php

/**
 * StreetSignal Formatter Tool Trait
 *
 * Gives objects a method for storing an formatter instance.
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Concerns;

use StreetSignal\Contracts\Formatter as FormatterInterface;

trait Formatter
{
    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @param  FormatterInterface $formatter
     * @return self
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }
}
