<?php

/**
 * StreetSignal Platform Create Form Attribute Use Case
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Platform
 * @copyright  2014 Ushahidi
 * @copyright 2025 Jascha Wanger / Tarnover, LLC
 * @license    https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License Version 3 (AGPL3)
 */

namespace StreetSignal\Core\Usecase\Form;

use StreetSignal\Core\Usecase\CreateUsecase;
use StreetSignal\Core\Usecase\Concerns\IdentifyRecords;
use StreetSignal\Core\Usecase\Concerns\VerifyStageLoaded;
use StreetSignal\Core\Usecase\Concerns\VerifyEntityLoaded;

class CreateFormAttribute extends CreateUsecase
{
    // - VerifyStageLoaded for checking that the stage exists
    use VerifyStageLoaded;

    // For form check:
    // - IdentifyRecords
    // - VerifyEntityLoaded
    use IdentifyRecords,
        VerifyEntityLoaded;

    // CreateUsecase
    protected function getEntity()
    {
        $entity = parent::getEntity();

        $this->verifyStageExists($entity);

        return $entity;
    }
}
