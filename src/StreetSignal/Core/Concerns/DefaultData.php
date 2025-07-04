<?php

/**
 * StreetSignal Platform Entity
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2022 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

trait DefaultData
{
    protected function addDefaultDataToArray(array $data = null)
    {
        // We can't define the method getDefaultData in this trait
        // due to the way method overriding works with trait inheritance.
        // The class using this trait can override the method,
        // but a subclass of that class cannot.
        if (method_exists($this, 'getDefaultData')) {
            // fill in available defaults for any missing values
            foreach ($this->getDefaultData() as $key => $default_value) {
                if (!isset($data[$key])) {
                    $data[$key] = $default_value;
                }
            }
        }

        return $data ?? [];
    }
}
