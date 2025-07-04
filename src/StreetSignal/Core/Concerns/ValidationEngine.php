<?php

/**
 * StreetSignal ValidationEngine Trait
 *
 * Gives objects a method for storing an instance of a Validation class
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Core
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Concerns;

use StreetSignal\Contracts\ValidationEngine as ValidationEngineContract;

trait ValidationEngine
{
    /**
     * @var \StreetSignal\Contracts\ValidationEngine
     */
    protected $validation_engine;

    /**
     * @param  $validation_factory
     * @return void
     */
    public function setValidation(ValidationEngineContract $validation_engine)
    {
        $this->validation_engine = $validation_engine;
    }
}
