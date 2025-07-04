<?php

/**
 * StreetSignal Platform Update Form Stage Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Form;

use StreetSignal\Core\Usecase\UpdateUsecase;
use StreetSignal\Core\Usecase\Concerns\VerifyFormLoaded;

class UpdateFormStage extends UpdateUsecase
{
    // - VerifyFormLoaded for checking that the form exists
    use VerifyFormLoaded;
}
