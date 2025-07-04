<?php

/**
 * StreetSignal Platform Read Form Role Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Form;

use StreetSignal\Core\Usecase\ReadUsecase;
use StreetSignal\Core\Usecase\Concerns\VerifyFormLoaded;

class ReadFormRole extends ReadUsecase
{
    // - VerifyFormLoaded for checking that the form exists
    use VerifyFormLoaded;
}
