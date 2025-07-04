<?php

/**
 * StreetSignal Platform Search Form Attribute Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Form;

use StreetSignal\Core\Usecase\SearchUsecase;
use StreetSignal\Core\Usecase\Concerns\IdentifyRecords;
use StreetSignal\Core\Usecase\Concerns\VerifyFormLoaded;
use StreetSignal\Core\Usecase\Concerns\VerifyEntityLoaded;

class SearchFormAttribute extends SearchUsecase
{
    // - VerifyFormLoaded for checking that the form exists
    use VerifyFormLoaded;

    // For form check:
    // - IdentifyRecords
    // - VerifyEntityLoaded
    use IdentifyRecords,
        VerifyEntityLoaded;

    protected function verifyFormExists()
    {
        if ($identifier = $this->getIdentifier('form_id')) {
            $form = $this->form_repo->get($identifier);
            $this->verifyEntityLoaded($form, $this->identifiers);
        }
    }
}
